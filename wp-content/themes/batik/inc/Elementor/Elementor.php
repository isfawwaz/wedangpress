<?php

namespace Batik\Elementor;

class Elementor {
	/**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register() {
		// Load Configuration
		$this->config = config( get_stylesheet_directory() . '/config/elementor.php' );

		// Hook Action
		add_action( 'lorasion_elementor_widgets', [ $this, 'load_elementor' ] );
	}

	public function load_elementor( $cls ) {
		if( is_array( $this->config ) ) {
			foreach( $this->config as $element ) {
				if( class_exists($element) ) {
					$cls->loadElementClass( $element );
				}
			}
		}
	}
}