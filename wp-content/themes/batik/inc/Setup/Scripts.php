<?php

namespace Batik\Setup;

class Scripts {
	/**
     * Extras config variable from extrax file
     * @var Array
     */
	private $config;

	private $styles = [];

	private $scripts = [];

	/**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register() {
		// Load config
		$this->config = config( get_stylesheet_directory() . '/config/scripts.php' );

		// Add hook
		if( isset($this->config['use_default_style']) && is_bool($this->config['use_default_style']) ) :
			add_filter( 'lorasin_use_default_style', [ $this, 'hook_default_style' ] );
		endif;

		if( isset( $this->config['use_default_script'] ) && is_bool( $this->config['use_default_script'] ) ) :
			add_filter( 'lorasin_use_default_script', [ $this, 'hook_default_script' ] );
		endif;

		// Add action
		add_action( 'lorasin_styles', [ $this, 'action_enqueue_styles' ] );
		add_action( 'lorasin_javascripts', [ $this, 'action_enqueue_scripts' ] );
	}

	public function hook_default_style() {
		return $this->config['use_default_style'];
	}

	public function hook_default_script() {
		return $this->config['use_default_script'];
	}

	public function action_enqueue_styles() {
		if( isset( $this->config['styles'] ) && is_array( $this->config['styles'] ) ) :
			$this->styles = $this->config['styles'];
		endif;

		foreach( $this->styles as $name => $style ) :
			wp_register_style( $name, $style, [], false, $media = 'all' );
			wp_enqueue_style( $name, $style, [], false, 'all' );
		endforeach;
	}

	public function action_enqueue_scripts() {
		if( isset( $this->config['script'] ) && is_array( $this->config['script'] ) ) :
			$this->scripts = $this->config['script'];
		endif;

		foreach( $this->scripts as $name => $script ) :
			wp_register_script( $name, $script, ['jquery'], false, true );
			wp_enqueue_script( $name, $script, ['jquery'], false, true );
		endforeach;
	}
}