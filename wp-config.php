<?php
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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'BE>#!c%TGa39);ne4W34%cY7[*<kiTOExQ)F J|&)_wg5<&}~Qj}Z*(-TGK3+T7)' );
define( 'SECURE_AUTH_KEY',   'r>&U+|hoG=8EBe`+ytJpQ#J</+yHkm9mC/v.zYp`M.NM:wSW*{Vo8F[:=./I29w%' );
define( 'LOGGED_IN_KEY',     'B+/_Qlc-LPUj(LVS6,gP9v0R-=4{q7:U^3Auz+?%?l7V?o,[eKCTHGD2P+5Hb.6p' );
define( 'NONCE_KEY',         'L9@yD@`^2{MFIlsfsd4N8Ie<C15q8jV=qOBDaMp=u)x7q4Wb^L,863|<KoO^&O_0' );
define( 'AUTH_SALT',         'Fk:$2[UXCz~,sS$|,x6#zcY*u^%]>|E.JSPX@@_YCf7rm_$Fsk6Vfwk4}2H[I$Ld' );
define( 'SECURE_AUTH_SALT',  '<2z3TS4-f#M)~ZH^jdl_]M20/qp3FWv~g-tO2wUKa{DX Nz_?:!B7Tnf(WGy|syM' );
define( 'LOGGED_IN_SALT',    '5jU~8}qp#?gS%V8%2Kgrq|i|6Y@v}A:gLWJ4x0=AqXe;*g4,ANhhI2nek(NM~6 {' );
define( 'NONCE_SALT',        '&9Ezh,tFsp-StQ~AlJiX?YR8)&15Hp5_+.cN#LRh$h2/,LmC9))/7;Ns~mD{[x&>' );
define( 'WP_CACHE_KEY_SALT', '7,lo@;+z_&(Ogm _{]ZUood@.xw~=9`}g.?[SrRoH`Z2xr{7!1{Ge!x/9KiPuPc$' );


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


define( 'WP_ENVIRONMENT_TYPE', 'local' );

// Activer le mode debug WordPress
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

