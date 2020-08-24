<?php

namespace Batik\Setup;

class Setup {
	/**
     * App config variable from app file
     * @var Array
     */
	private $configApp;

	/**
     * Media config variable from media file
     * @var Array
     */
    private $configMedia;

	/**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register() {
    	// Load config
    	$this->configApp = config( get_stylesheet_directory() . '/config/app.php' );
    	$this->configMedia = config( get_stylesheet_directory() . '/config/media.php' );

    	// Load hook
		$this->load_hook();
    }

    /**
     * Load hook for lorasin theme
     * @return
     */
    private function load_hook() {
    	$app = $this->configApp;
    	$media = $this->configMedia;

    	// Custom Background Customizer Args
    	if( isset($app['custom_background_args']) && is_array($app['custom_background_args']) ) :
    		add_filter('lorasin_custom_background_args', [ $this, 'hook_custom_background_args' ] );
    	endif;

    	// Post Formats
    	if( isset( $app['post_format'] ) && is_array( $app['post_format'] ) ) :
    		add_filter( 'lorasin_post_formats', [ $this, 'hook_post_format' ] );
	    endif;

	    // Media Sizes
	    if( !empty($media) && is_array($media) ) :
	    	add_filter( 'lorasin_media_size', [ $this, 'hook_media_size' ] );
	    endif;

	    // Excerpt More Text
	    if( isset( $app['excerpt_more'] ) && !empty( $app['excerpt_more'] ) ) :
	    	add_filter( 'lorasin_excerpt_more', [ $this, 'hook_excerpt_more' ] );
	    endif;

	    // Excerpt Length
	    if( isset( $app['excerpt_length'] ) && !empty( $app['excerpt_length'] ) ) :
	    	add_filter( 'lorasin_excerpt_length', [ $this, 'hook_excerpt_length' ] );
	    endif;

	    // Admin Footer Text
	    if( isset( $app['footer_text'] ) && !empty( $app['footer_text'] ) ) :
	    	add_filter( 'lorasin_admin_footer_text', [ $this, 'hook_admin_footer_text' ], 9999 );
		endif;

		date_default_timezone_set('Asia/Jakarta');
    }

    public function hook_custom_background_args() {
    	return $this->configApp['custom_background_args'];
    }

    public function hook_post_format() {
    	return $this->configApp['post_format'];
    }

    public function hook_media_size() {
    	return $this->configMedia;
    }

    public function hook_excerpt_more() {
    	return $this->configApp['excerpt_more'];
    }

    public function hook_excerpt_length() {
    	return $this->configApp['excerpt_length'];
    }

    public function hook_admin_footer_text() {
    	return $this->configApp['footer_text'];
	}
}