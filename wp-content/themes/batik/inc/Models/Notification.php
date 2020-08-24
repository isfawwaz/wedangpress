<?php

namespace Batik\Models;

use Batik\Collections\DatabaseNotificationCollection;

class Notification extends Model {

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wahaha_notifications';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'show_at' => 'datetime'
    ];

    /**
     * Get the notifiable entity that the notification belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Mark the notification as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        if (! is_null($this->read_at)) {
            $this->forceFill(['read_at' => null])->save();
        }
    }

    /**
     * Mark the notification as showed
     * 
     * @return void
     */
    public function markAsShow() {
        if( is_null( $this->show_at ) ) {
            $this->forceFill( ['show_at' => $this->freshTimestamp() ] )->save();
        }
    }

    /**
     * Mark the notification as unshowed
     * 
     * @return void
     */
    public function markAsUnshow() {
        if( is_null( $this->show_at ) ) {
            $this->forceFill( ['show_at' => null ] )->save();
        }
    }

    /**
     * Determine if a notification has been read.
     *
     * @return bool
     */
    public function read()
    {
        return $this->read_at !== null;
    }

    /**
     * Determine if a notification has not been read.
     *
     * @return bool
     */
    public function unread()
    {
        return $this->read_at === null;
    }

    /**
     * Determine if a notification has been showed.
     * 
     * @return bool
     */
    public function showed() {
        return $this->show_at !== null;
    }

    /**
     * Determine if a notification has not been showed.
     * 
     * @return void
     */
    public function unshowed() {
        return $this->show_at == null;
    }

    /**
     * Create a new database notification collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function newCollection(array $models = [])
    {
        return new DatabaseNotificationCollection($models);
    }

}