<?php

namespace Batik\Setup;

class Extras {
	/**
     * Extras config variable from extrax file
     * @var Array
     */
	private $config;

	/**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register()
	{
		// Load config
		$this->config = config( get_stylesheet_directory() . '/config/extras.php' );

		/*
		 * Register hook
		 */
		
		// Multi author body clasess
		if( isset( $this->config['multi_author_body_clasess'] ) ) :
			add_filter( 'lorasin_multi_author_body_classess', [ $this, 'hook_multi_body_clasess' ] );
		endif;

		// Singular body clasess
		if( isset( $this->config['singular_body_clasess'] ) ) :
			add_filter( 'lorasin_singular_body_classess', [ $this, 'hook_singular_body_clasess' ] );
		endif;

		// Body clasess
		if( isset( $this->config['body_clasess'] ) ) :
			add_filter( 'lorasin_body_clasess', [ $this, 'hook_body_clasess' ] );
		endif;
	}

	public function hook_multi_body_clasess() {
		return $this->config['multi_author_body_clasess'];
	}

	public function hook_singular_body_clasess() {
		return $this->config['singular_body_clasess'];
	}

	public function hook_body_clasess() {
		return $this->config['body_clasess'];
	}
}