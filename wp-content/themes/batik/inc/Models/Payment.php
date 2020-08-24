<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_payments';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'payment_type',
        'transaction_id',
        'status_id',
        'method_id',
        'timestamp',
        'source',
        'amount',
        'gateway_response',
        'transaction_id_chq_number',
        'po_number',
        'extra_accounting',
        'details',
        'redirect_url',
        'redirect_args'
    ];

    protected $dates = [
        'timestamp'
    ];

    public function scopeByTransactionId( $query, $id ) {
        return $query->where('transaction_id', $id);
    }

    public function scopeByStatusId( $query, $id ) {
        return $query->where('status_id', $id);
    }

    public function scopeByApproved( $query ) {
        return $query->byStatusId(20);
    }

    public function scopeByCancelled( $query ) {
        return $query->byStatusId(21);
    }

    public function scopeByDeclined( $query ) {
        return $query->byStatusId(22);
    }

    public function scopeByFailed( $query ) {
        return $query->byStatusId(23);
    }

    public function scopeByMethodId( $query, $id ) {
        return $query->where('method_id', $id);
    }

    public function payment_method() {
        return $this->belongsTo('Batik\Models\PaymentMethod', 'method_id');
    }

    public function payment_status() {
        return $this->belongsTo('Batik\Models\Status', 'status_id');
    }

    public function transaction() {
        return $this->belongsTo('Batik\Models\Transaction', 'transaction_id');
    }

    public function getStatusTextClassesAttribute() {
        return $this->get_status_text_class_name();
    }

    public function getBorderClassesAttribute() {
        return $this->get_status_border_class_name();
    }

    public function getStatusNameAttribute() {
        $status = $this->payment_status;
        $className = $this->get_status_text_class_name();

        return '<span class="'. $className .'">'. $status->name .'</span>';
    }

    public function getMethodNameAttribute() {
        $method = $this->payment_method;

        if( !empty($method) ) {
            return $method->name;
        }

        return '&mdash;';
    }
    
}