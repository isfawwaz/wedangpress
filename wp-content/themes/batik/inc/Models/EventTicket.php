<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EventTicket extends Model {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_event_tickets';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'post_id',
        'name',
        'qty',
        'sold',
        'reserved',
        'uses',
        'is_required',
        'ticket_min',
        'ticket_max',
        'price',
        'start_date',
        'end_date',
        'taxable',
        'total_order',
        'start_row',
        'is_default',
        'wp_user',
        'parent',
        'deleted'
    ];

    public function scopeByEventId( $query, $id ) {
        return $query->where('post_id', $id);
    }

    public function event() {
        return $this->belongsTo('Batik\Models\Post', 'post_id');
    }

}