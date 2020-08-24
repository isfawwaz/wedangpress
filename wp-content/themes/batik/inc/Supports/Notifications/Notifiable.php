<?php

namespace Batik\Supports\Notifications;

use Batik\Models\Notification;
use ReflectionClass;

trait Notifiable {
    use HasDatabaseNotifications;

    public function notify( NotificationInterface $notification ) {
        if( !method_exists( $notification, 'toArray' ) ) {
            return;
        }
        
        if( method_exists( $notification, 'via' ) ) {
            $via = [];
            if( !is_array( $notification->via() ) ) {
                $via[] = $notification->via();
            } else {
                $via = $notification->via();
            }

            foreach( $via as $item ) {
                if( $item == 'database' ) {
                    $this->send_database( $notification );
                }

                if( $item == 'mail' ) {
                    $this->send_mail( $notification );
                }
            }
        }
    }

    private function send_database( $notification ) {
        $id = UUID::v1('wahaha-grg');
        $notifiableId = $this->ID;
        $type = $this->slugify_classname( $notification );
        $data = $notification->toArray();

        $z = new Notification();
        $z->id = $id;
        $z->type = $type;
        $z->notifiable_type = 'Gragas\Models\User';
        $z->notifiable_id = $notifiableId;
        $z->data = $data;
        $z->save();

        return $z;
    }

    private function send_mail( $notification ) {
        // 
    }

    private function slugify_classname( $class ) {
        $z = new ReflectionClass( $class );

        return $z->getName();
    }
}