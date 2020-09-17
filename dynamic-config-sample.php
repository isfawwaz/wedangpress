<?php
// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'CONFIG_DB_NAME', '' );

/** MySQL database username */
define( 'CONFIG_DB_USER', 'root' );

/** MySQL database password */
define( 'CONFIG_DB_PASSWORD', '' );

/** MySQL hostname */
define( 'CONFIG_DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'CONFIG_DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'CONFIG_DB_COLLATE', '' );

/** Disable file edit through dashboard */
define( 'DISALLOW_FILE_EDIT', true );

/** Disabled automatic update */
define( 'AUTOMATIC_UPDATER_DISABLED', true );

/** Define debug */
// Enable WP_DEBUG mode
define( 'WP_DEBUG', false );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', false );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', false );