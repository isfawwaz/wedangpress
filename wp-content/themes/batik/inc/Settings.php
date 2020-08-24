<?php
/**
 * Sample implementation of the Settings Options for Theme
 *
 * @package Gragas
 */

/**
 * Get option settings
 * 
 * @param string $name Name of optino
 * @return string
 */
function get_setting( $name ) {
    return wp_unslash( get_option($name) );
}


/**
 * Base function for getting option and print it
 * 
 * @param string $name Name of setting
 * @param bool $print Print option or return it
 * @return string Option settings
 */
function get_setting_func( $name, $print ) {
    $data = get_setting( $name );

    if( $print ) {
        echo $data;
    }

    return $data;
}

/**
 * Get option for company tagline
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists('get_setting_company_tagline') ) :
    function get_setting_company_tagline( $print = false) {
        return get_setting_func( 'company_tagline', $print );
    }
endif;

/**
 * Get option for company phone
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_company_phone' ) ) :
    function get_setting_company_phone( $print = false ) {
        return get_setting_func( 'company_phone', $print );
    }
endif;

if ( ! function_exists( 'get_setting_company_phone_hotel' ) ) :
    function get_setting_company_phone_hotel( $print = false ) {
        return get_setting_func( 'company_phone_hotel', $print );
    }
endif;

/**
 * Get option for company fax
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_company_fax' ) ) :
    function get_setting_company_fax( $print = false ) {
        return get_setting_func( 'company_fax', $print );
    }
endif;

/**
 * Get option for company email
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_company_email' ) ) :
    function get_setting_company_email( $print = false ) {
        return get_setting_func( 'company_email', $print );
    }
endif;

if ( ! function_exists( 'get_setting_company_email_hotel' ) ) :
    function get_setting_company_email_hotel( $print = false ) {
        return get_setting_func( 'company_email_hotel', $print );
    }
endif;

/**
 * Get option for company email
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_company_address' ) ) :
    function get_setting_company_address( $print = false ) {
        return get_setting_func( 'company_address', $print );
    }
endif;

/**
 * Get option for social media facebook
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_sosmed_facebook' ) ) :
    function get_setting_sosmed_facebook( $print = false ) {
        return get_setting_func( 'sosmed_facebook', $print );
    }
endif;

/**
 * Get option for social media instagram
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_sosmed_instagram' ) ) :
    function get_setting_sosmed_instagram( $print = false ) {
        return get_setting_func( 'sosmed_instagram', $print );
    }
endif;

/**
 * Get option for social media twitter
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_sosmed_twitter' ) ) :
    function get_setting_sosmed_twitter( $print = false ) {
        return get_setting_func( 'sosmed_instagram', $print );
    }
endif;

/**
 * Get option for social media youtube
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_sosmed_youtube' ) ) :
    function get_setting_sosmed_youtube( $print = false ) {
        return get_setting_func( 'sosmed_youtube', $print );
    }
endif;

/**
 * Get option for custom css
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_custom_css' ) ) :
    function get_setting_custom_css( $print = false ) {
        return get_setting_func( 'custom_css_single', $print );
    }
endif;

/**
 * Get option for javascript head
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_custom_js_head' ) ) :
    function get_setting_custom_js_head( $print = false ) {
        return get_setting_func( 'custom_js_head', $print );
    }
endif;

/**
 * Get option for javascript single
 * 
 * @param bool $print Print option or return it
 * @return string
 */
if ( ! function_exists( 'get_setting_custom_js_single' ) ) :
    function get_setting_custom_js_single( $print = false ) {
        return get_setting_func( 'custom_js_single', $print );
    }
endif;