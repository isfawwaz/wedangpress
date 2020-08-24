<?php

namespace Batik\Setup;

class Menus {
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
		$this->config = config( get_stylesheet_directory() . '/config/menus.php' );

		/*
		 * Register Hook
		 */
		
		// List Menu Positions
		if( !empty($this->config) && is_array($this->config) && count($this->config) > 0 ) :
			add_filter( 'lorasin_menus', [ $this, 'hook_menu_position' ] );
		endif;
	}

	public function hook_menu_position() {
		return $this->config;
	}
}