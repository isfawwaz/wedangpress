<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodMeta extends Model {

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
        'type',
        'method_id',
        'title',
        'instruction'
    ];

    public function scopeById( $query, $id ) {
        return $query->where('id', $id);
    }

    public function scopeByMethodId( $query, $id ) {
        return $query->where('method_id', $id);
    }
}