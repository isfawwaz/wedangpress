<?php

namespace Batik\Setup;

class Taxonomies {
	/**
     * Extras config variable from extrax file
     * @var Array
     */
	private $config;

	/**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register() {
		// Load config
		$this->config = config( get_stylesheet_directory() . '/config/taxonomies.php' );

		/**
		 * Add hook
		 */
		if( is_array( $this->config ) ) :
			add_filter( 'lorasin_custom_taxonomies', [ $this, 'hook_custom_taxonomies' ] );
		endif;
	}

	public function hook_custom_taxonomies() {
		return $this->config;
	}
}