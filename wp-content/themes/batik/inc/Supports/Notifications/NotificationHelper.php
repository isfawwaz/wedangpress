<?php

namespace Batik\Supports\Notifications;

use Batik\Daos\RegistrationDao;
use Batik\Daos\UserDao;
use Batik\Traits\Columns\ColumnLink;

Class NotificationHelper extends ColumnLink {

    protected $registrationDao;

    protected $userDao;

    public function __construct() {
        $this->registrationDao = new RegistrationDao();
        $this->userDao = new UserDao();
    }

    private function admin_user_ids(){
        //Get all users in the DB
        $wp_user_search = $this->userDao->all();
    
        //Blank array
        $adminArray = array();

        //Loop through all users
        foreach ( $wp_user_search as $userid ) {

            //Current user ID we are looping through
            $curID = $userid->ID;

            //Grab the user info of current ID
            $curuser = get_userdata($curID);

            //Current user level
            $user_level = $curuser->user_level;

            //Only look for admins
            if($user_level >= 8){//levels 8, 9 and 10 are admin
                
                //Push user ID into array
                $adminArray[] = $this->userDao->detail( $curID );
            }
        }
        
        return $adminArray;
    }

    protected function sendNotifications( $notification ) {
        $users = $this->admin_user_ids();

        foreach( $users as $item ) {
            $item->notify( $notification );
        }
    }

    protected function _notification_content( $data, $isOnList = true ) {
        if( empty($data) ) {
            return false;
        }

        $ret = [];

        switch( $data->type ) {

            /**
             * Notification for karaoke room
             */
            case 'Gragas\Notifications\KaraokeNewRegistration':
                $json = $data->data;

                $registration = $this->registrationDao->karaokeById( $json['registration_id'] );
                if( empty($registration) ) {
                    return false;
                }

                $title = 'New Registration for Karaoke Room';
                $content = 'You have new registration that need to be reviewed';
                $link = $this->karaokeRegistrationLink( $registration->id );
                $icon = 'dashicons-before dashicons-store';
                $type = 'alert';

                $ret = [
                    'title' => $title,
                    'content' => $content,
                    'icon' => $icon,
                    'link' => $link,
                    'type' => $type
                ];
                break;

            /**
             * Notification for hotel room
             */
            case 'Gragas\Notifications\HotelNewRegistration':
                $json = $data->data;

                $registration = $this->registrationDao->hotelById( $json['registration_id'] );
                if( empty($registration) ) {
                    return false;
                }

                $title = 'New Registration for Hotel Room';
                $content = 'You have new registration that need to be reviewed';
                $link = $this->hotelRegistrationLink( $registration->id );
                $icon = 'dashicons-before dashicons-building';
                $type = 'success';

                $ret = [
                    'title' => $title,
                    'content' => $content,
                    'icon' => $icon,
                    'link' => $link,
                    'type' => $type
                ];
                break;

            /**
             * Notification for lounge & bar
             */
            case 'Gragas\Notifications\LoungeNewRegistration':
                $json = $data->data;

                $registration = $this->registrationDao->loungeById( $json['registration_id'] );
                if( empty($registration) ) {
                    return false;
                }

                $title = 'New Registration for Lounge & Bar';
                $content = 'You have new registration that need to be reviewed';
                $link = $this->loungeRegistrationLink( $registration->id );
                $icon = 'dashicons-before dashicons-buddicons-tracking';
                $type = 'info';

                $ret = [
                    'title' => $title,
                    'content' => $content,
                    'icon' => $icon,
                    'link' => $link,
                    'type' => $type
                ];
                break;
        }

        if( $isOnList ) {
            $ret['is_readed'] = !empty( $data->read_at );
        }

        $ret['timestamp'] = $data->created_at->diffForHumans();

        return $ret;
    }
    
}