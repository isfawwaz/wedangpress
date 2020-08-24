<?php

namespace Batik\Setup;

class Search {
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
		$this->config = config( get_stylesheet_directory() . '/config/search.php' );

		// Add hook
		if( isset( $this->config['post_type'] ) && is_array( $this->config['post_type'] ) ) :
			add_filter( 'lorasin_filter_search_post', [ $this, 'hook_filter_search' ] );
		endif;
	}

	public function hook_filter_search() {
		return $this->config['post_type'];
	}
}