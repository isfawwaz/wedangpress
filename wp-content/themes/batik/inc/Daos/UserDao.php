<?php

namespace Batik\Daos;

use Batik\Models\User;

class UserDao {

    public function all() {
        return User::select(['ID', 'display_name'])->orderBy('ID')->get();
    }

    public function detail( $id ) {
        return User::byId( $id )->first();
    }
}