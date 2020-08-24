<?php

namespace Batik\Supports\Notifications;

interface NotificationInterface {
    
    public function via();
    public function toArray();
    
}