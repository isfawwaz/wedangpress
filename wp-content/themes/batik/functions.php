<?php
/**
 * Gragas functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Gragas
 */

if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) :
	require_once get_template_directory() . '/vendor/autoload.php';
endif;

if ( file_exists( get_stylesheet_directory() . '/vendor/autoload.php' ) ) :
	require_once get_stylesheet_directory() . '/vendor/autoload.php';
endif;

if ( file_exists( dirname( __FILE__ ) . '/../../../vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/../../../vendor/autoload.php';
endif;

require_once( 'inc/Helpers.php' );

if ( class_exists( 'Batik\\Init' ) ) :
	Batik\Init::register_services();
endif;