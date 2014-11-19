<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'xmedia');

/** MySQL database username */
define('DB_USER', 'xmedia');

/** MySQL database password */
define('DB_PASSWORD', 'xmedia');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'rQa|:N&%|i59_wz,d6*Hd#Jb|) Xw@^lSb}F7r/)<m%ze Tb|uM6(-Gu2+^4E{JN');
define('SECURE_AUTH_KEY',  'vdoXI(Pc%avct*36(a~}|;M5kE)7{b/+(:U|,Nc03)3iajhR(Wzw(|[MouOA[T!5');
define('LOGGED_IN_KEY',    '!4{`Iwnc}tn- @(E3:h.rp<+ucm?b?,WEiO@F-~FLFrSn(hy+xR kzo]p|pw;(+<');
define('NONCE_KEY',        '8?Nb5VNu!xp#c665=px|6qe<|Vw;O2^-?d8UKE]tL?xYhY}jkAJ^-Keu@0b(#c %');
define('AUTH_SALT',        '>&Fu|K:TP~T=*x3|Hakuh2-s):0.p`){16k5>^+CVZTtaK-*5,@|L+XAwp)&|Yn(');
define('SECURE_AUTH_SALT', '}:6yXOo!bF|$B][rjM`nAhjF02_J.^&(]PJY7Vg&bwEtJ X10swO!E|fd%re]!*|');
define('LOGGED_IN_SALT',   '&INeF-ZcB+B6.,5uHBsOG8P3W&CjuXXmTn72)1*jNgl]/6O,HD,,fk?Jcc}uDY$m');
define('NONCE_SALT',       '2dq|a|Oaz$PGYMD?{A$rV6I< 11iDY6d*ciHoal4cJNeq0-~$=v@ojF+:W?38!Qr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
