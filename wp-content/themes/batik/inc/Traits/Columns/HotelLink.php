<?php

namespace Batik\Traits\Columns;

class HotelLink extends HotelBase {

    public function hotelRegistrationLink( $id ) {
        return $this->registrationDetailLink( $id );
    }
    
}