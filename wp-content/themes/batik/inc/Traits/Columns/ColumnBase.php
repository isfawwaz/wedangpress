<?php

namespace Batik\Traits\Columns;

abstract class ColumnBase {

    abstract protected function nonce_registration_detail_action() : string;

    abstract protected function nonce_registration_trash_action() : string;

    abstract protected function nonce_registration_restore_action() : string;

    abstract protected function nonce_registration_filter_action() : string;

    abstract protected function nonce_contact_edit_action() : string;

    abstract protected function nonce_contact_trash_action() : string;

    abstract protected function nonce_contact_restore_action() : string;

    abstract protected function nonce_contact_filter_action() : string;

    abstract protected function nonce_transaction_detail_action() : string;

    abstract protected function nonce_transaction_filter_action() : string;

    abstract protected function post_type() : string;

    abstract protected function registration_post_type() : string;

    abstract protected function transaction_post_type() : string;

    abstract protected function contact_post_type() : string;

    protected function nonce_registration_detail_name() : string {
        return 'view_registration_nonce';
    }

    protected function nonce_registration_trash_name() : string {
        return 'action_transaction_nonce';
    }

    protected function nonce_registration_restore_name() : string {
        return 'action_registration_nonce';
    }

    protected function nonce_registration_filter_name() : string {
        return 'view_registration_nonce';
    }

    protected function nonce_contact_edit_name() : string {
        return 'view_registration_contact_nonce';
    }

    protected function nonce_contact_trash_name() : string {
        return 'action_registration_contact_nonce';
    }

    protected function nonce_contact_restore_name() : string {
        return 'action_registration_contact_nonce';
    }

    protected function nonce_contact_filter_name() : string {
        return 'view_registration_contact_nonce';
    }

    protected function nonce_transaction_detail_name() : string {
        return 'view_transaction_nonce';
    }

    protected function nonce_transaction_filter_name() : string {
        return 'view_transaction_nonce';
    }

    protected function base_link() {
        $url = admin_url('edit.php');
        $url = add_query_arg('post_type', $this->post_type(), $url);

        return $url;
    }

    public function baseRegistrationLink() {
        $url = $this->base_link();
        $url = add_query_arg('page', $this->registration_post_type(), $url);

        return $url;
    }

    public function baseTransactionLink() {
        $url = $this->base_link();
        $url = add_query_arg('page', $this->transaction_post_type(), $url);

        return $url;
    }

    public function baseContactLink() {
        $url = $this->base_link();
        $url = add_query_arg('page', $this->contact_post_type(), $url);

        return $url;
    }

    public function editLink($id) {
        return get_edit_post_link( $id );
    }

    public function registrationDetailLink( $id ) {
        $url = $this->baseRegistrationLink();
        $url = add_query_arg( 'action', 'view_registration', $url );
        $url = add_query_arg( 'registration_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_registration_detail_action(), $this->nonce_registration_detail_name() );

        return $url;
    }

    public function registrationTrashLink( $id ) {
        $url = $this->baseRegistrationLink();
        $url = add_query_arg( 'action', 'trash_registration', $url );
        $url = add_query_arg( 'registration_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_registration_trash_action(), $this->nonce_registration_trash_name() );

        return $url;
    }

    public function registrationRestoreLink( $id ) {
        $url = $this->baseRegistrationLink();
        $url = add_query_arg( 'action', 'restore_registration', $url );
        $url = add_query_arg( 'registration_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_registration_restore_action(), $this->nonce_registration_restore_name() );

        return $url;
    }

    public function registrationFilterLink( $id ) {
        $url = $this->baseRegistrationLink();
        $url = add_query_arg('hotel_id', $id, $url);
        $url = add_query_arg('status', strtolower( $_REQUEST['status'] ), $url );
        $url = wp_nonce_url( $url, $this->nonce_registration_filter_action(), $this->nonce_registration_filter_name() );

        return $url;
    }

    public function contactEditLink( $id ) {
        $url = $this->baseContactLink();
        $url = add_query_arg( 'action', 'edit_attendance', $url );
        $url = add_query_arg( 'attendace_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_contact_edit_action(), $this->nonce_contact_edit_name() );

        return $url;
    }

    public function contactTrashLink( $id ) {
        $url = $this->baseContactLink();
        $url = add_query_arg( 'action', 'trash_attendance', $url );
        $url = add_query_arg( 'attendance_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_contact_trash_action(), $this->nonce_contact_trash_name() );

        return $url;
    }

    public function contactRestoreLink( $id ) {
        $url = $this->baseContactLink();
        $url = add_query_arg( 'action', 'restore_attendance', $url );
        $url = add_query_arg( 'attendance_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_contact_restore_action(), $this->nonce_contact_restore_name() );

        return $url;
    }

    public function contactFilterLink( $id ) {
        $url = $this->baseContactLink();
        $url = add_query_arg( 'attendance_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_contact_filter_action(), $this->nonce_contact_filter_name() );

        return $url;
    }

    public function transactionDetailLink( $id ) {
        $url = $this->baseTransactionLink();
        $url = add_query_arg( 'action', 'view_transaction', $url );
        $url = add_query_arg( 'transaction_id', $id, $url );
        $url = wp_nonce_url( $url, $this->nonce_transaction_detail_action(), $this->nonce_transaction_detail_name() );

        return $url;
    }

    public function transactionFilterLink( $id ) {
        $url = $this->baseTransactionLink();
        $url = add_query_arg('hotel_id', $id, $url);
        $url = add_query_arg('status', $_REQUEST['status'], $url);
        $url = wp_nonce_url( $url, $this->nonce_transaction_filter_action(), $this->nonce_transaction_filter_name() );

        return $url;
    }

}