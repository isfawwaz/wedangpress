<?php

namespace Batik\Setup;

class Settings {

    public function register() {
        // Setting option - must be filled for custom setting to work
        // Option:
        // 1. lorasin_options_company_group
        // 2. lorasin_options_sosmed_group
        // 3. lorasin_options_css_group
        // 4. lorasin_options_js_group
        add_filter( 'lorasin_settings_filter', [ $this, 'admin_setting' ] );

        // Setting fields
        add_filter( 'lorasin_admin_field_company', [ $this, 'admin_field_company' ]);
        add_filter( 'lorasin_admin_field_social', [ $this, 'admin_field_social' ] );
        add_filter( 'lorasin_admin_field_css', [ $this, 'admin_field_css' ] );
        add_filter( 'lorasin_admin_field_js', [ $this, 'admin_field_js' ] );
    }

    public function admin_setting( $options ) {
        // Add setting custom phone hotel
        $options[] = [
            'option_group' => 'lorasin_options_company_group',
            'option_name' => 'company_phone_hotel'
        ];

        // Add setting custom email hotel
        $options[] = [
            'option_group' => 'lorasin_options_company_group',
            'option_name' => 'company_email_hotel'
        ];
        
        return $options;
    }

    public function admin_field_company( $options ) {
        // $addon = [];

        // // Unset field tagline
        // unset( $options['tagline'] );
        // unset( $options['fax'] );

        // // Change phone number label
        // $options['phone']['title'] = __('Phone Number - Karaoke', 'lorasin');
        // $options['phone']['args']['description'] = __('Your karaoke official phone line', 'lorasin');

        // // Add custom phone number hotel
        // $addon[] = [
        //     'id' => 'company_phone_hotel',
        //     'title' => __( 'Phone Number - Hotel', 'lorasin' ),
        //     'callback' => 'field_render',
        //     'page' => 'theme_settings',
        //     'section' => 'theme_setting_company_information',
        //     'args' => [
        //         'option' => 'company_phone_hotel',
        //         'name' => 'company_phone_hotel',
        //         'placeholder' => __( '+62-8XX-XXXX-XXXX', 'lorasin' ),
        //         'description' => __( 'Your hotel official phone line', 'lorasin' ),
        //     ],
        // ];

        // // Change email label
        // $options['email']['title'] = __('Email - Karaoke', 'lorasin');
        // $options['email']['args']['description'] = __('Your karaoke official email account', 'lorasin');

        // // Add custom email hotel
        // $addon[] = [
        //     'id' => 'company_email_hotel',
        //     'title' => __( 'Email - Hotel', 'lorasin' ),
        //     'callback' => 'field_render',
        //     'page' => 'theme_settings',
        //     'section' => 'theme_setting_company_information',
        //     'args' => [
        //         'option' => 'company_email_hotel',
        //         'name' => 'company_email_hotel',
        //         'placeholder' => __( 'hi@company.domain', 'lorasin' ),
        //         'description' => __( 'Your hotel official email account', 'lorasin' ),
        //     ],
        // ];

        // // Merge array
        // array_splice( $options, 2, 0, $addon );

        return $options;
    }

    public function admin_field_social( $options ) {
        return $options;
    }
    
    public function admin_field_css( $options ) {
        return $options;
    }

    public function admin_field_js( $options ) {
        return $options;
    }

}