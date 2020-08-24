<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class KaraokeRoomPrice extends Model {

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
        'karaoke_room_id',
        'name',
        'price',
        'count_hour',
        'is_package',
        'start_time',
        'end_time'
    ];
}