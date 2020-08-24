<?php

namespace Batik\Traits\Columns;

class ColumnLink {

    protected $hotelLink;

    protected $karaokeLink;

    protected $loungeLink;

    public function __construct() {
        $this->hotelLink = new HotelLink();
        $this->karaokeLink = new KaraokeLink();
        $this->loungeLink = new LoungeLink();
    }

    public function __call($name, $arguments) {
        // Check function exists on hotel
        if( method_exists( $this->hotelLink, $name ) ) {
            call_user_func_array( [ $this->hotelLink, $name], $arguments );
        }

        // Check function exists on karaoke
        if( method_exists( $this->karaokeLink, $name ) ) {
            call_user_func_array( [ $this->karaokeLink, $name], $arguments );
        }

        // Check function exists on lounge
        if( method_exists( $this->loungeLink, $name ) ) {
            call_user_func_array( [ $this->loungeLink, $name], $arguments );
        }
    }
}