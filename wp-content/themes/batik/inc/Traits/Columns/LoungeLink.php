<?php

namespace Batik\Traits\Columns;

class LoungeLink extends LoungeBase {

    public function loungeRegistrationLink( $id ) {
        return $this->registrationDetailLink( $id );
    }
    
}