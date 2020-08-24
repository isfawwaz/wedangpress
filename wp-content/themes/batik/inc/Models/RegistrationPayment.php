<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationPayment extends Model {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_registration_payments';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'registration_id',
        'payment_id',
        'pay_amount'
    ];

    public function scopeByRegistrationId( $query, $id ) {
        return $query->where('registration_id', $id);
    }

    public function scopeByPaymentId( $query, $id ) {
        return $query->where('payment_id', $id);
    }

    public function payment() {
        return $this->belongsTo('Batik\Models\Payment', 'payment_id');
    }

    public function registration() {
        return $this->belongsTo('Batik\Models\Registration', 'registration_id');
    }

}