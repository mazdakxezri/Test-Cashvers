<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

define( 'ITSEC_ENCRYPTION_KEY', 'TCheIEpvMTA2SXlDaVs8QiZOZXJZUmItI2RhZT8gPzlFI2x1dWQ1aiRiT2tzfCZeOEU4LiA9dko3RTpFc3drJg==' );

define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u876970906_QHKEa' );

/** Database username */
define( 'DB_USER', 'u876970906_FEogT' );

/** Database password */
define( 'DB_PASSWORD', '1j88Oeb80k' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '^|~`E<3C!ee$DaRlZQ0Ze~m.z0LtEJ-(R/dWC5VZ7~x/1QFFP%@=E*,4xfS5j%9A' );
define( 'SECURE_AUTH_KEY',   'SrK?;;Hcp6t%<|a*T+js%p|y`6|8.,m>.b^R7bNV7Z%}&_DwR:*%E}R|RYX81CXA' );
define( 'LOGGED_IN_KEY',     'C*QTq)>qSfGFsQ|4S1!K[!wP/slgFV]Qj_nb5G8cKEp6Z`q.gOf50lx)ncq.U+Nv' );
define( 'NONCE_KEY',         '1>r&Z!aF3kK%U! aoSn*3B*$3J3HHs.vTLZI/>vA2nI?P~-#@%$?O;NR3iC7.=JZ' );
define( 'AUTH_SALT',         '^)=ac^[NT]2]hzHC}a%`=#z:r/N7ohhJotVmfI0BJUY]v=m)@:z.ms}V^V,DQy6,' );
define( 'SECURE_AUTH_SALT',  '@LUqOfDJ2L*jUS;h}MN(|9g!G/u#{UZy.i<,uE<Ya5W$:t<T%NMQ%otfW-`u]  d' );
define( 'LOGGED_IN_SALT',    '7+1=gg80zp.cS4yz#+IBW/$RVbLZK%ZK40PW){*6T+%-@NVm01$nLw%)gV[r}<>Z' );
define( 'NONCE_SALT',        'S,25N4<hvX[R:#lKgrZxEDKCW50abre1bn+7&H?f?SmgO_LFmq+7yPJAeq~.6XPB' );
define( 'WP_CACHE_KEY_SALT', 'YG]<=v%#+c>#Bs_>_ah0@gtdK/pjPY2^Pyw?}HO@7VQ@5$Xl9acbULtF8VWn_c*N' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'bf9ff765edbd5ab0080ff2d466ec1bb6' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
