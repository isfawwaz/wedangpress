<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `config/custom/custom.php` to write your custom functions
 *
 * @package lorasin
 */

namespace Batik;

final class Init {
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services() {
		return [
			Setup\Extras::class,
			Setup\Menus::class,
			Setup\Posts::class,
			Setup\Scripts::class,
			Setup\Search::class,
			Setup\Settings::class,
			Setup\Setup::class,
			Setup\Sidebar::class,
			Setup\Taxonomies::class,
			Setup\Woocommerce::class,
			Elementor\Elementor::class,

			/**
			 * METABOX
			 */

			# Metabox - Page
			Metaboxes\PageLayoutMetabox::class,
		];
	}

	/**
	 * Loop through the classes, initialize them, and call the register() method if it exists
	 * @return
	 */
	public static function register_services()
	{
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register') ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class 		class from the services array
	 * @return class instance 		new instance of the class
	 */
	private static function instantiate( $class )
	{
		return new $class();
	}
}