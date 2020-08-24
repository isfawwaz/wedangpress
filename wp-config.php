<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

if ( file_exists( dirname( __FILE__ ) . '/live-config.php' ) ) {
    define( 'WP_LOCAL_DEV', false );
    define( 'DBI_STAGING_SITE', false );
    include dirname( __FILE__ ) . '/live-config.php';
}
elseif ( file_exists( dirname( __FILE__ ) . '/staging-config.php' ) ) {
    define( 'WP_LOCAL_DEV', false );
    define( 'DBI_STAGING_SITE', true );
    include dirname( __FILE__ ) . '/staging-config.php';
}
elseif ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
    define( 'WP_LOCAL_DEV', true );
    define( 'DBI_STAGING_SITE', false );
    include dirname( __FILE__ ) . '/local-config.php';
}
else {
    $error = 'Error 500 - Config not found';
    new Exception($error);
    echo "<h1>$error</h1><hr />";
    die();
}

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', CONFIG_DB_NAME );

/** MySQL database username */
define( 'DB_USER', CONFIG_DB_USER );

/** MySQL database password */
define( 'DB_PASSWORD', CONFIG_DB_PASSWORD );

/** MySQL hostname */
define( 'DB_HOST', CONFIG_DB_HOST );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', CONFIG_DB_CHARSET );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', CONFIG_DB_COLLATE );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = CONFIG_DB_PREFIX;




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
