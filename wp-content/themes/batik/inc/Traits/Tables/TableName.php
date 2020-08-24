<?php

namespace Batik\Traits\Tables;

trait TableName {

    public $tableAttendanceMeta = 'wahaha_attendance_metas';

    public $tableEventTicket = 'wahaha_event_tickets';

    public $tableHotelRoomAvailbility = 'wahaha_hotel_room_availabilities';

    public $tableKaraokeRoomPrice = 'wahaha_karaoke_room_price';

    public $tableKaraokeRoomAvailibility = 'wahaha_karaoke_room_availabilities';

    public $tableLoungeBarAvailibility = 'wahaha_lounge_bar_availabilities';

    public $tableNotification = 'wahaha_notifications';

    public $tablePaymentMethod = 'wahaha_payment_methods';

    public $tablePaymentMethodMeta = 'wahaha_payment_method_metas';

    public $tablePayment = 'wahaha_payments';

    public $tableRegistration = 'wahaha_registrations';

    public $tableRegistrationPayment = 'wahaha_registration_payments';

    public $tableStatus = 'wahaha_statuses';

    public $tableTransaction = 'wahaha_transactions';

    public $charset = 'utf8';

    public $isInit = false;

    public function initTableName() {
        global $wpdb;

        $prefix = $wpdb->base_prefix;

        $this->tableAttendanceMeta = $prefix . $this->tableAttendanceMeta;
        $this->tableEventTicket = $prefix . $this->tableEventTicket;
        $this->tableHotelRoomAvailbility = $prefix . $this->tableHotelRoomAvailbility;
        $this->tableKaraokeRoomPrice = $prefix . $this->tableKaraokeRoomPrice;
        $this->tableKaraokeRoomAvailibility = $prefix . $this->tableKaraokeRoomAvailibility;
        $this->tableLoungeBarAvailibility = $prefix . $this->tableLoungeBarAvailibility;
        $this->tableNotification = $prefix . $this->tableNotification;
        $this->tablePayment = $prefix . $this->tablePayment;
        $this->tablePaymentMethod = $prefix . $this->tablePaymentMethod;
        $this->tablePaymentMethodMeta = $prefix . $this->tablePaymentMethodMeta;
        $this->tableRegistration = $prefix . $this->tableRegistration;
        $this->tableRegistrationPayment = $prefix . $this->tableRegistrationPayment;
        $this->tableStatus = $prefix . $this->tableStatus;
        $this->tableTransaction = $prefix . $this->tableTransaction;

        $this->charset = $wpdb->get_charset_collate();

        $this->isInit = true;
    }
    
}