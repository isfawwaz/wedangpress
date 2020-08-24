<?php

namespace Batik\Traits\Columns;

class KaraokeBase extends ColumnBase {

    protected function nonce_registration_detail_action() : string {
        return 'wahaha_room_action_registration_detail';
    }

    protected function nonce_registration_trash_action() : string {
        return 'wahaha_room_action_transaction_detail';
    }

    protected function nonce_registration_restore_action() : string {
        return 'wahaha_room_action_registration_restore';
    }

    protected function nonce_registration_filter_action() : string {
        return 'wahaha_room_action_registration_filter';
    }

    protected function nonce_contact_edit_action() : string {
        return 'wahaha_room_action_registration_contact_detail';
    }

    protected function nonce_contact_trash_action() : string {
        return 'wahaha_room_action_registration_contact_trash';
    }

    protected function nonce_contact_restore_action() : string {
        return 'wahaha_room_action_registration_contact_restore';
    }

    protected function nonce_contact_filter_action() : string {
        return 'wahaha_room_action_registration_contact_filter';
    }

    protected function nonce_transaction_detail_action() : string {
        return 'wahaha_room_action_transaction_detail';
    }

    protected function nonce_transaction_filter_action() : string {
        return 'wahaha_room_action_transaction_filter';
    }

    protected function post_type() : string {
        return 'room';
    }

    protected function registration_post_type() : string {
        return 'wahaha_room_registration';
    }

    protected function transaction_post_type() : string {
        return 'wahaha_room_transaction';
    }

    protected function contact_post_type() : string {
        return 'wahaha_room_contact';
    }
    
}