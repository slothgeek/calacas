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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'calacas' );

/** MySQL database username */
define( 'DB_USER', 'phpmyadmin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'C4str1ll0.1' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'e)5bG,<&S[pn(<;E)yMS39hFoS{)J?0x)RJhfDu;J)>%3PuTu1$,j`7.}YL?CH3#' );
define( 'SECURE_AUTH_KEY',  '.Ty*+,<;}}5t1~e4m b2!KB`40-1m_MKIaiNq6Zz<f%51xIw+HMW6<k/5)r6Z_te' );
define( 'LOGGED_IN_KEY',    '9{m0]p|$PAPAZ)B1A@CJVFz,qsEn5ND0-sYj$@bhy;u=lU-Tt;fiiLkO}Nf;rKS.' );
define( 'NONCE_KEY',        '9nSuGE_5~D%QYkPff&15]EEoY1@Z6$9wL/SewQA;F9_{z@P_4hIgm{u!~ZniT[6t' );
define( 'AUTH_SALT',        ' ob::(vJ|>{ls5@_b|cXKdNY%(v?msX/xG7Q&]uwq8Uswf1K?s{-3>Stu1q!|P8~' );
define( 'SECURE_AUTH_SALT', '=}.<r|x,H@QBeIZwNVNQ#+BfGfg64H9_QJ(YGpA,MCp*zNT[;yVy7);zQ+ssb)c=' );
define( 'LOGGED_IN_SALT',   'T~L`i8C4h7CNpkfJmu.Z=+!^99k(_u@XAduS>39P;!>[jNtm~|]lVS  xGJVBJ>m' );
define( 'NONCE_SALT',       'S_;^/]<UK]rG:VW9WyhuOlc+R&t;W~wQx=./XGRN)0^5I@?4t[nL8>`s)~D8*Otr' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
