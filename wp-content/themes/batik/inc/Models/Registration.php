<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_registrations';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'registration_type',
        'post_id',
        'attendance_id',
        'transaction_id',
        'status_id',
        'reg_date',
        'reg_final_price',
        'reg_paid',
        'reg_session',
        'reg_code',
        'reg_url_link',
        'reg_count',
        'reg_group_size',
        'reg_att_is_going',
        'reg_delete'
    ];

    public function scopeKaraoke( $query ) {
        return $query->where('registration_type', get_data_type_karaoke());
    }

    public function scopeHotel( $query ) {
        return $query->where('registration_type', get_data_type_hotel());
    }

    public function scopeLounge( $query ) {
        return $query->where('registration-type', get_data_type_karaoke());
    }

    public function scopeByRoomId( $query, $id ) {
        return $query->where('room_id', $id);
    }

    public function scopeByAttendanceId( $query, $id ) {
        return $query->where( 'attendance_id', $id );
    }

    public function scopeByAttendance( $query ) {
        return $query->where( 'attendance_id', '!=', '0' );
    }

    public function scopeByTransactionId( $query, $id ) {
        return $query->where( 'transaction_id', $id );
    }

    public function scopeByStatusId( $query, $id ) {
        return $query->where( 'status_id', $id );
    }

    public function scopeByApproved( $query ) {
        return $query->byStatusId( 26 );
    }

    public function scopeByCancelled( $query ) {
        return $query->byStatusId( 27 );
    }

    public function scopeByDeclined( $query ) {
        return $query->byStatusId( 28 );
    }

    public function scopeByIncomplete( $query ) {
        return $query->byStatusId( 29 );
    }

    public function scopeByNotApproved( $query ) {
        return $query->byStatusId( 30 );
    }

    public function scopeByPendingPayment( $query ) {
        return $query->byStatusId( 31 );
    }

    public function scopeByWaitList( $query ) {
        return $query->byStatusId( 32 );
    }

    public function scopeExceptIncomplete( $query ) {
        return $query->where('status_id', '!=', 29);
    }

    public function scopeByRegUrlLink( $query, $link ) {
        return $query->where('reg_url_link', $link);
    }

    public function scopeByRegSession( $query, $session ) {
        return $query->where('reg_session', $session);
    }

    public function scopeByRoomDate( $query, $date, $operator = '>=' ) {
        if( is_a($date, 'Carbon\Carbon') ) {
            return  $query->where('room_date', $operator, $date->format('Y-m-d'));
        }

        return $query->where('room_date', $operator, $date);
    }

    public function scopeByCurrentMonth( $query ) {
        $now = Carbon::now('Asia/Jakarta');
        $startOfMonth = $now->startOfMonth()->format('Y-m-d h:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d h:i:s');
        return $query->whereBetween( 'reg_date', [ $startOfMonth, $endOfMonth ]);
    }

    public function scopeByCurrentDay( $query ) {
        $now = Carbon::now('Asia/Jakarta');
        $startOfDay = $now->startOfDay()->format('Y-m-d h:i:s');
        $endOfDay = $now->endOfDay()->format('Y-m-d h:i:s');
        return $query->whereBetween( 'reg_date', [ $startOfDay, $endOfDay ]);
    }

    public function scopeByDates( $query, $start, $end ) {
        return $query->whereBetween( 'room_timestamp', [ $start, $end ] );
    }

    public function scopeSearch( $query, $search ) {
        return $query->where( function($query) use($search) {
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
    }

    public function scopeFindPrev( $query, $currentId ) {
        return $query->select('*')->where('id', '<', $currentId)->max('id');
    }

    public function scopeFindNext( $query, $currentId ) {
        return $query->select('*')->where('id', '>', $currentId)->min('id');
    }

    public function room() {
        return $this->belongsTo('Batik\Models\Post', 'room_id');
    }

    public function attendance() {
        return $this->belongsTo('Batik\Models\AttendanceMeta', 'attendance_id', 'attendance_id')->withTrashed();
    }

    public function transaction() {
        return $this->belongsTo('Batik\Models\Transaction', 'transaction_id');
    }

    public function status() {
        return $this->belongsTo('Batik\Models\Status', 'status_id');
    }

    public function getStatusTextClassesAttribute() {
        return $this->get_status_text_class_name();
    }

    public function getBorderClassesAttribute() {
        return $this->get_status_border_class_name();
    }

    public function getTextStatusColoredAttribute() {
        $status = $this->status;
        $badgeClass = $this->get_status_text_class_name();

        return '<span class="'. $badgeClass .'">'. ucwords( strtolower( unslugify( $status->name ) ) ) .'</span>';
    }

    public function getStatusNameAttribute() {
        $status = $this->status;
        if( !empty($this->deleted_at) ) {
            return Status::byId( 27 )->first()->name;
        }

        return $status->name;
    }
}