<?php

namespace Batik\Models;

class User extends Model {

    protected $primaryKey = 'ID';
    protected $timestamp = false;

    public function scopeById( $query, $id ) {
        return $query->where( 'ID', $id );
    }

    public function meta()
    {
        return $this->hasMany('Batik\Models\UserMeta', 'user_id');
    }
}