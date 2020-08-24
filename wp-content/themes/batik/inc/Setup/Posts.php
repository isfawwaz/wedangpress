<?php

namespace Batik\Setup;

class Posts {
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
		$this->config = config( get_stylesheet_directory() . '/config/posts.php' );

		/*
		 * Register Hook
		 */
		
		// Custom Post Types
		if( !empty( $this->config ) && is_array( $this->config ) && count( $this->config ) > 0 ) :
			add_filter( 'lorasin_custom_post_types', [ $this, 'hook_custom_post_types' ] );
		endif;
	}

	public function hook_custom_post_types() {
		return $this->config;
	}
}