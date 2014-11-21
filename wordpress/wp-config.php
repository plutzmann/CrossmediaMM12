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
define('AUTH_KEY',         'am/u[_Hy*]c-Bz8J6ws|9R%G/Us1(z|aW-=ebQMDUz)qVA|e>M^(~KVzY/5rx*dY');
define('SECURE_AUTH_KEY',  'y%QUnfhki71m@t[D{8R8[I{6HW-u.CYK4;A!+bq(*sKT+*Ch_d)hw*-[t,A)Y92a');
define('LOGGED_IN_KEY',    'y4$ 3@LZ+Klhf)%d;zr8YP~1E8?>aRX<FW 9mM;b-f]n6?M+e%IXVoY%YM}|Lx+o');
define('NONCE_KEY',        'g%}rHeSS[pdd(7Tix>1e6*Tx3V.1$}TP{sU+NgtnDLc;kK#zXAE)gek#6jfadm1H');
define('AUTH_SALT',        'bu@;GD6>v_YH2@J+@#@XW;TFxoqNRQ$6d@L0h2ic<lw+q#`|,9t Su-a0WHwpy#N');
define('SECURE_AUTH_SALT', 'v}Yv#4+QwkJ+j;*cI28<6wz&x@!sKrAGY(!<U9#(iiPyC{6|5@JMDw/VF3]2Yok;');
define('LOGGED_IN_SALT',   'Wutbz()mBwZv+ihhqg!c^+z^DjR$e-n}CtiRIeq}?oUzx-lH|k+aW-WZz_W_Tdy6');
define('NONCE_SALT',       '1TagS]|x |:S-AOqxb)f}waCHqn=v^T<96o<Qb|IwfYyZ8VM18,fny.GK3o|5F5i');

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
