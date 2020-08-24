<?php

namespace Batik\Traits\Tables;

trait TableStructure {

    use TableName;

    public function createTableAttendanceMeta() {
        return "CREATE TABLE `{$this->tableAttendanceMeta}` (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            attendance_id bigint(20) UNSIGNED NULL,
            fullname varchar(45) NULL,
            address varchar(255) NULL,
            city varchar(45) NULL,
            postcode varchar(45) NULL,
            email varchar(255) NULL,
            phone varchar(45) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY  (id)
        ) {$this->charset};";
    }

    public function createTableEventTicket() {
        return "CREATE TABLE `{$this->tableEventTicket}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id BIGINT(20) NOT NULL,
            name VARCHAR(255) NULL,
            qty INT NULL DEFAULT(0),
            sold INT NULL DEFAULT(0),
            reserved SMALLINT NULL DEFAULT(0),
            uses TINYINT NULL DEFAULT(0),
            is_required TINYINT(1) NULL DEFAULT(0),
            ticket_min TINYINT NULL DEFAULT(0),
            ticket_max TINYINT NULL DEFAULT(1),
            price DECIMAL(12,3) NULL DEFAULT(0),
            start_date DATETIME NULL,
            end_date DATETIME NULL,
            taxable TINYINT(1) NULL DEFAULT(0),
            total_order TINYINT NULL DEFAULT(0),
            start_row TINYINT NULL DEFAULT(0),
            is_default TINYINT(1) NULL DEFAULT(0),
            wp_user BIGINT NULL,
            parent BIGINT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableHotelRoomAvailbility() {
        return "CREATE TABLE `{$this->tableHotelRoomAvailbility}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id BIGINT NOT NULL,
            date DATE NULL,
            availability INT NULL DEFAULT(0),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableKaraokeRoomPrice() {
        return "CREATE TABLE `{$this->tableKaraokeRoomPrice}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            karaoke_room_id BIGINT NOT NULL,
            name VARCHAR(255) NULL,
            price DECIMAL(12,3) NULL DEFAULT(0),
            count_hour TINYINT NULL DEFAULT(1),
            is_package TINYINT(1) NULL DEFAULT(0),
            start_time TIME NULL,
            end_time TIME NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableKaraokeRoomAvailability() {
        return "CREATE TABLE `{$this->tableKaraokeRoomAvailibility}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id BIGINT NOT NULL,
            date Date NULL,
            availability INT DEFAULT(0),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableLoungeBarAvailability() {
        return "CREATE TABLE `{$this->tableLoungeBarAvailibility}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id BIGINT NOT NULL,
            date Date NULL,
            availability INT DEFAULT(0),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableNotification() {
        return "CREATE TABLE `{$this->tableNotification}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            type VARCHAR(191) NULL,
            notifiable_type VARCHAR(191) NULL,
            notifiable_id BIGINT NULL,
            data TEXT NULL,
            clicked TINYINT(1) NULL DEFAULT(0),
            show_at TIMESTAMP NULL,
            read_at TIMESTAMP NULL,
            click_at TIMESTAMP NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTablePayment() {
        return "CREATE TABLE `{$this->tablePayment}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            payment_type TINYINT NULL,
            transaction_id BIGINT NOT NULL,
            status_id BIGINT NOT NULL,
            method_id BIGINT NOT NULL,
            timestamp TIMESTAMP NOT NULL,
            source VARCHAR(45) NULL,
            amount DECIMAL(12,3) NULL DEFAULT(0),
            gateway_response TEXT NULL,
            chq_number VARCHAR(100) NULL,
            po_number VARCHAR(100) NULL,
            extra_accounting VARCHAR(100) NULL,
            details TEXT NULL,
            redirect_uri VARCHAR(300) NULL,
            redirect_args VARCHAR(300) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTablePaymentMethod() {
        return "CREATE TABLE `{$this->tablePaymentMethod}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            type VARCHAR(124) NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            admin_name VARCHAR(124) NULL,
            admin_description TEXT NULL,
            slug VARCHAR(255) NULL,
            data_order INT NULL DEFAULT(0),
            debug_mode TINYINT(1) DEFAULT(0),
            wp_user INT NULL,
            open_by_default TINYINT(1) DEFAULT(0),
            button_url TEXT NULL,
            scope VARCHAR(255) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTablePaymentMethodMeta() {
        return "CREATE TABLE `{$this->tablePaymentMethodMeta}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            type TINYINT NOT NULL,
            method_id BIGINT NOT NULL,
            title VARCHAR(255) NULL,
            instruction TEXT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableRegistration() {
        return "CREATE TABLE `{$this->tableRegistration}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            registration_type TINYINT NOT NULL,
            post_id BIGINT NOT NULL,
            attendance_id BIGINT NOT NULL,
            status_id BIGINT NOT NULL,
            transaction_id BIGINT NOT NULL,
            reg_meta TEXT NULL,
            reg_date DATE NULL,
            reg_final_price DECIMAL(12,3) NULL DEFAULT(0),
            reg_paid DECIMAL(12,3) NULL DEFAULT(0),
            reg_session VARCHAR(45) NULL,
            reg_code VARCHAR(45) NULL,
            reg_url_link VARCHAR(64) NULL,
            reg_count TINYINT NULL DEFAULT(0),
            reg_group_size TINYINT NULL DEFAULT(1),
            reg_att_is_going TINYINT NULL DEFAULT(0),
            reg_delete TINYINT(1) NULL DEFAULT(1),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableRegistrationPayment() {
        return "CREATE TABLE `{$this->tableRegistrationPayment}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            registration_id BIGINT NOT NULL,
            payment_id BIGINT NOT NULL,
            pay_amount DECIMAL(12,3) NULL DEFAULT(0),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableStatus() {
        return "CREATE TABLE `{$this->tableStatus}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            code VARCHAR(3) NOT NULL,
            name VARCHAR(100) NOT NULL,
            type VARCHAR(45) NULL,
            description TEXT NULL,
            can_edit TINYINT(1) DEFAULT(0),
            is_open TINYINT(1) DEFAULT(0),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

    public function createTableTransaction() {
        return "CREATE TABLE `{$this->tableTransaction}` (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            status_id BIGINT NOT NULL,
            method_id BIGINT NOT NULL,
            timestamp TIMESTAMP NULL,
            total DECIMAL(12,3) NULL DEFAULT(0),
            paid DECIMAL(12,3) NULL DEFAULT(0),
            session_data TEXT NULL,
            hash_salt VARCHAR(255) NULL,
            reg_steps TEXT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        ) {$this->charset};";
    }

}