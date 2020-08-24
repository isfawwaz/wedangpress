<?php

namespace Batik\Traits\Columns;

class KaraokeLink extends KaraokeBase {

    public function karaokeRegistrationLink( $id ) {
        return $this->registrationDetailLink( $id );
    }
    
}