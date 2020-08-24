<?php

namespace Batik\Daos;

use Batik\Models\Registration;

class RegistrationDao {

    public function karaokeById( $id ) {
        return Registration::karaoke()->find($id);
    }

    public function hotelById( $id ) {
        return Registration::hotel()->find($id);
    }

    public function loungeById( $id ) {
        return Registration::lounge()->find($id);
    }

}