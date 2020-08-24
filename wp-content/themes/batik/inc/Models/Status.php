<?php

namespace Batik\Models;

class Status extends Model {

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_statuses';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'code',
        'name',
        'type',
        'can_edit',
        'status_description',
        'is_open'
    ];

    public function scopeById( $query, $id ) {
        return $query->where( 'id', $id );
    }

    public function scopeByCode( $query, $code ) {
        return $query->where('code', 'like', '%'.$code.'%');
    }

    public function scopeByType( $query, $type ) {
        return $query->where('type', $type);
    }

    public function getStatusTextClassesAttribute() {
        return $this->get_status_text_class_name();
    }

    public function getLoweredNameAttribute() {
        return ucwords( strtolower( unslugify( $this->name ) ) );
    }

}