<?php

namespace Batik\Models;

class PaymentMethod extends Model {

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_payment_methods';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'type',
        'name',
        'method_desc',
        'admin_name',
        'admin_desc',
        'slug',
        'date_order',
        'debug_mode',
        'wp_user',
        'open_by_default',
        'button_url',
        'scope',
    ];

    public function scopeById( $query, $id ) {
        return $query->where('id', $id);
    }

    public function scopeCart( $query ) {
        return $query->where('scope', 'like', '%cart%' );
    }

    public function scopeAdmin( $query ) {
        return $query->where('scope', 'like', '%admin%' );
    }

    public function scopeBySlug( $query, $slug ) {
        return $query->where('slug', $slug);
    }

    public function scopeNotInvoice( $query ) {
        return $query->where('type', '!=', 'Invoice');
    }

    public function instruction() {
        return $this->hasOne('Batik\Models\PaymentMethodInstruction', 'method_id', 'id')->withDefault();
    }

    public function getIsCartAttribute() {
        $scope = unserialize( $this->scope );

        if( in_array('CART', $scope) ) {
            return true;
        }

        return false;
    }

    public function getIsAdminAttribute() {
        $scope = unserialize( $this->scope );

        if( in_array('ADMIN', $scope) ) {
            return true;
        }

        return false;
    }

    public function getPublicNameAttribute() {
        $instruction = $this->instruction;

        if( !empty($instruction->title) ) {
            return $instruction->title;
        }

        return $this->name;
    }

}