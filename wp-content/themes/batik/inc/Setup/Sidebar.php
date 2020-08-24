<?php

namespace Batik\Setup;

class Sidebar {
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
		$this->config = config( get_stylesheet_directory() . '/config/sidebar.php' );

		// Filter html
		add_filter( 'lorasin_widget_before_widget', function() {
			return '<section id="%1$s" class="widget %2$s">';
		});

		/**
		 * Add hook
		 */
		// Sidebar regular
		if( isset( $this->config['sidebar'] ) && is_array( $this->config['sidebar'] ) ) :
			add_filter( 'lorasin_widgets', [ $this, 'hook_widgets' ] );
		endif;

		// Sidebar with no title
		if( isset( $this->config['sidebar_no_title'] ) && is_array( $this->config['sidebar_no_title'] ) ) :
			add_filter( 'lorasin_widgets_no_title', [ $this, 'hook_widgets_no_title' ] );
		endif;
	}

	public function hook_widgets() {
		return $this->config['sidebar'];
	}

	public function hook_widgets_no_title() {
		return $this->config['sidebar_no_title'];
	}
}