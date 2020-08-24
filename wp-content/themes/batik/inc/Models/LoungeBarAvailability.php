<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class KaraokeRoomAvailability {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_lounge_bar_availabilities';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'post_id',
        'date',
        'availability'
    ];
    
    public function scopeByPostId( $query, $id ) {
        return $query->where('post_id', $id);
    }
    
}