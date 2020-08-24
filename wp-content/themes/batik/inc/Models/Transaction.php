<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_transactions';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'status_id',
        'method_id',
        'timestamp',
        'total',
        'paid',
        'session_data',
        'hash_salt',
        'reg_steps'
    ];

    protected $dates = [
        'timestamp'
    ];

    public function scopeById( $query, $id ) {
        return $query->where('id', $id);
    }

    public function scopeByStatusId( $query, $id ) {
        return $query->where('status_id', $id);
    }

    public function scopeByMethodId( $query, $id ) {
        return $query->where('method_id', $id);
    }

    public function scopeByRoomId( $query, $roomId ) {
        return $query->wherehas('room_registration', function($query) use($roomId) {
            return $query->where('room_id', $roomId);
        });
    }

    public function scopeByTimestamp( $query, $timestamp ) {
        return $query->where('timestamp', $timestamp);
    }

    public function scopeByNotAbandoned( $query ) {
        return $query->where('status_id', '!=', 34);
    }

    public function scopeByNotIncomplete( $query ) {
        return $query->where('status_id', '!=', 37);
    }

    public function scopeByAbandoned( $query ) {
        return $query->byStatusId( 34 );
    }

    public function scopeByIncomplete( $query ) {
        return $query->byStatusId( 37 );
    }

    public function scopeCustomOrder( $query, $orderBy, $order ) {
        switch( strtolower( $orderBy ) ) {
            case 'id':
                return $query->orderBy( $orderBy, $order );
                break;

            case 'date':
                return $query->orderBy('timestamp', $order);
                break;

            case 'attendance':
                return $query->whereHas('room_registration', function($query) use($order) {
                    return $query->whereHas('attendance', function($query) use($order) {
                        return $query->orderBy('fullname', $order);
                    });
                });
                break;

            case 'room':
                return $query->whereHas('room_registration', function($query) use($order) {
                    return $query->whereHas('room', function($query) use($order) {
                        return $query->orderBy('post_title', $order);
                    });
                });
                break;
        }
        return $query;
    }

    public function scopeByDates( $query, $start, $end ) {
        if( is_a($start, 'Carbon\Carbon') && is_a($end, 'Carbon\Carbon') ) {
            return $query->whereBetween('timestamp', [$start->format('Y-m-d h:i:s'), $end->format('Y-m-d h:i:s')]);
        } else {
            return $query->whereBetween('timestamp', [$start, $end]);
        }
    }

    public function scopeSearch( $query, $search ) {
        return $query->where( function($query) use($search) {
            $query->whereHas('room_registration', function($query) use($search) {
                $query->whereHas('room', function($query) use($search) {
                    $query->where( 'post_title', 'like', "%$search%");
                });
                $query->orWhereHas('attendance', function($query) use($search) {
                    $query->where('fullname', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhere('address2', 'like', "%$search%")
                        ->orWhere('city', 'like', "%$search%")
                        ->orWhere('postcode', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                });
            });
        });
    }

    public function status() {
        return $this->belongsTo('Batik\Models\Status', 'status_id');
    }

    public function payments() {
        return $this->hasMany('Batik\Models\Payment', 'transaction_id', 'id');
    }

    public function payment_method() {
        return $this->belongsTo('Batik\Models\PaymentMethod', 'method_id');
    }

    public function room_registration() {
        return $this->hasOne('Batik\Models\RoomRegistration', 'transaction_id', 'id');
    }

    public function room_registrations() {
        return $this->hasMany('Batik\Models\RoomRegistration', 'transaction_id', 'id');
    }

    public function getStatusTextClassesAttribute() {
        return $this->get_status_text_class_name();
    }

    public function getBorderClassesAttribute() {
        return $this->get_status_border_class_name();
    }

    public function getTransactionStatusAttribute() {
        $status = $this->status;
        $badgeClass = $this->get_status_badge_class_name();

        return '<span class="badge badge-pill badge-sm '. $badgeClass .'">&nbsp;</span> '. ucfirst( strtolower( $status->name ) ) .'';
    }

    public function getTextStatusColoredAttribute() {
        $badgeClass = $this->get_status_text_class_name();

        return '<span class="'. $badgeClass .'">'. ucfirst( strtolower( $this->statusName ) ) .'</span>';
    }

    public function getTotalAmountTextClassesAttribute() {
        if( $this->total > 0 ) {
            if( $this->paid == 0 ) {
                return 'text-status-failed';
            } elseif( $this->paid < $this->total ) {
                return 'text-status-incomplete';
            } elseif( $this->paid == $this->total ) {
                return 'text-status-complete';
            } elseif( $this->paid > $this->total ) {
                return 'text-status-overpaid';
            }
        }

        return;
    }

    public function getSessionIdAttribute() {
        $session = unserialize( $this->session_data );
        if( isset($session['id']) ) {
            return $session['id'];
        }

        return '&mdash;';
    }

    public function getSessionUserIdAttribute() {
        $session = unserialize( $this->session_data );
        if( isset($session['user_id']) ) {
            return $session['user_id'];
        }

        return '&mdash;';
    }

    public function getSessionIpAttribute() {
        $session = unserialize( $this->session_data );
        if( isset($session['ip_address']) ) {
            return $session['ip_address'];
        }

        return '&mdash;';
    }

    public function getSessionUserAgentAttribute() {
        $session = unserialize( $this->session_data );
        if( isset($session['user_agent']) ) {
            return $session['user_agent'];
        }

        return '&mdash;';
    }

    public function getSessionInitAccessAttribute() {
        $session = unserialize( $this->session_data );
        if( isset($session['init_access']) ) {
            return $session['init_access'];
        }

        return '&mdash;';
    }

    public function getSessionLastAccessAttributes() {
        $session = unserialize( $this->session_data );
        if( isset($session['last_access']) ) {
            return $session['last_access'];
        }

        return '&mdash;';
    }

    public function getSessionExpirationAttributes() {
        $session = unserialize( $this->session_data );
        if( isset($session['expiration']) ) {
            return $session['expiration'];
        }

        return '&mdash;';
    }

    public function getStatusNameAttribute() {
        $status = $this->status;
        if( !empty($this->deleted_at) ) {
            return Status::byId( 27 )->first()->name;
        }

        return $status->name;
    }

    public function getIsStepPersonalInformationAttribute() {
        $steps = unserialize( $this->reg_steps );
        return isset($steps['attendance_information']);
    }

    public function getIsStepPaymentOptionsAttribute() {
        $steps = unserialize( $this->reg_steps );
        return isset( $steps['payment_options']);
    }

    public function getIsStepFinalizeRegistrationAttribute() {
        $steps = unserialize( $this->reg_steps );
        return isset( $steps['payment_options']);
    }

    public function getStepAttendanceCompleteAttribute() {
        if( $this->isStepPersonalInformation ) {
            $steps = unserialize( $this->reg_steps )['attendance_information'];
            if( $steps == 0 ) {
                return 'Failed';
            }

            return 'Completed';
        }

        return;
    }

    public function getStepPaymentCompleteAttribute() {
        if( $this->isStepPaymentOptions ) {
            $steps = unserialize( $this->reg_steps )['payment_options'];
            if( $steps == 0 ) {
                return 'Failed';
            }

            return 'Completed';
        }

        return;
    }

    public function getStepFinalizeCompleteAttribute() {
        if( $this->isStepPaymentOptions ) {
            $steps = unserialize( $this->reg_steps )['finalize_registration'];
            if( $steps == 0 ) {
                return 'Failed';
            }

            return 'Completed';
        }

        return;
    }
}