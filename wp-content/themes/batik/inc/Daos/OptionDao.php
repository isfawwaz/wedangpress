<?php

namespace Batik\Daos;

class OptionDao {

    protected $optDbVersion = 'batik_wahaha_db_version';

    public function getDbVersion() {
        return (int) get_site_option( $this->optDbVersion );
    }

    public function updateDbVersion(int $value) {
        update_site_option( $this->optDbVersion, $value );
    }
    
}