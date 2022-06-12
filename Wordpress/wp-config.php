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
define( 'DB_NAME', 'atlasbik_atlasbike' );

/** MySQL database username */
define( 'DB_USER', 'atlasbik_atlasbike' );

/** MySQL database password */
define( 'DB_PASSWORD', ']L4uA}3[K!Ee' );

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
define( 'AUTH_KEY',         '{ye(z@H^-slf)|.B_Joc7Ff;?Lxi&p.rKN[va}2[OtnX-3bvOGX~Tlq`4VWur22!' );
define( 'SECURE_AUTH_KEY',  ' O}fNWw/$&8a%$C[=WEQL%rs:1vygIe{Ulm1pS|Uwjg?F0?<9,G[!8$2xlFEN]e;' );
define( 'LOGGED_IN_KEY',    'g8eug^xlR!.ryRc3!OGe=< oO3uZNAJaXd,w@kp}:K62og`/O>H4knr3JI> fc+~' );
define( 'NONCE_KEY',        'J:scDaL-$D.TXgCWM-GFj|?yrDhjrwD4DH5=g:~g??Yp^ndAiHxD)T+6 1s{qWSz' );
define( 'AUTH_SALT',        'dlwD]%wJ;J&.6G&d_//mtk{LFBI!3a|W/O6rb]?[w,^]`xsqVUQ>W^1l:G]cG d-' );
define( 'SECURE_AUTH_SALT', ')~4DK`<RRf{Vzw<t,l,(MKu[7T$4~S0O=EQNuQB1s<(t~.MO2|UA!~MQ_X>1^4@#' );
define( 'LOGGED_IN_SALT',   'HxlfeT6n0;qan2}jv&{P,<X>+7DB^1@U>!+1,azvpgr$&BYkvw[74j6;dSawL[p=' );
define( 'NONCE_SALT',       'k/,6RP<8MI9km/ T}B2%wi{YI$Uer9=*b{?aL8QT}HMQT5@*/+7W@,fbn6_F0v%7' );

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
