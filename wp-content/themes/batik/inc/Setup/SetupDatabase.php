<?php

namespace Batik\Setup;

use Batik\Traits\Tables\TableData;
use Batik\Traits\Tables\TableStructure;

class SetupDatabase {

    use TableStructure, TableData;

    public function register() {
        $version = (int) get_site_option( 'batik_wahaha_db_version' );

        if( $version < 1 || empty($version) ) {

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            // Init Table Name
            $this->initTableName();

            // Create table
            dbDelta( $this->createTableAttendanceMeta() );
            dbDelta( $this->createTableEventTicket() );
            dbDelta( $this->createTableHotelRoomAvailbility() );
            dbDelta( $this->createTableKaraokeRoomPrice() );
            dbDelta( $this->createTableKaraokeRoomAvailability() );
            dbDelta( $this->createTableLoungeBarAvailability() );
            dbDelta( $this->createTableNotification() );
            dbDelta( $this->createTablePayment() );
            dbDelta( $this->createTablePaymentMethod() );
            dbDelta( $this->createTablePaymentMethodMeta() );
            dbDelta( $this->createTableRegistration() );
            dbDelta( $this->createTableRegistrationPayment() );
            dbDelta( $this->createTableStatus() );
            dbDelta( $this->createTableTransaction() );

            update_site_option( 'batik_wahaha_db_version', 1 );
        }
    }
    
}