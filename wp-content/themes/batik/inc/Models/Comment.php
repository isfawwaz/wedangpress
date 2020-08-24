<?php

namespace Batik\Models;

class Comment extends Model {
    
    protected $primaryKey = 'comment_ID';

    /**
     * Post relation for a comment
     *
     * @return HasOne
     *
     * @since 1.0.0
     */
    public function post()
    {
        return $this->hasOne('Batik\Models\Post');
    }
}