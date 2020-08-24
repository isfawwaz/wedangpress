<?php

namespace Batik\Supports\Notifications;

trait HasDatabaseNotifications {

    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications() {
        return $this->morphMany('Batik\Models\Notification', 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function readNotifications() {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Get the entity's unread notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unreadNotifications() {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Get the entity's showed notifications.
     * 
     * @return \Illuminate\Database\Query\Builder
     */
    public function showedNotifications() {
        return $this->notifications()->whereNotNull('show_at');
    }

    /**
     * Get the entity's unshowed notifications.
     * 
     * @return \Illuminate\Database\Query\Builder
     */
    public function unshowNotifications() {
        return $this->notifications()->whereNull('show_at');
    }

}