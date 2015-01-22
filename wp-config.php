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
define('DB_NAME', 'cseed');

/** MySQL database username */
define('DB_USER', 'cseed');

/** MySQL database password */
define('DB_PASSWORD', 'cseed');

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
define('AUTH_KEY',         '!<3?5$)oYP4cpCYI98D&l{Q0EUth,PH:9r#U1e||Ijfg(Z:y%bV7i)Xf--,|Ktsh');
define('SECURE_AUTH_KEY',  'mWaP`EM?-LiADHtKvx;p+Bm5[l~[}S}Qw]x-1.>$2*`o@:[9(4O7K&4B/?;9A<3#');
define('LOGGED_IN_KEY',    'nI`M:F@n?%Z+?vB2!}#5<,o)Y<&`(%E5S| 5+QKdRmXD%=m^R/C kg0Ft;;Yww?)');
define('NONCE_KEY',        'fY9}|2IzV;&h5CR;SSZu:Jx?&+XL+9])QP61~}D)5$9SRg5D!gtoS?vw~m/lEr}S');
define('AUTH_SALT',        '|8.mMa:m4H]-k#+vK=T$n|B=^CA=_)z#Hgj9}{7q[-{+OzZFL.aiKL4I-D48YX[<');
define('SECURE_AUTH_SALT', '_43p[q,>.+j6Zc-crYJ<$+L5qgs;`+@fb`J$fA><3$&wF#uB<(o0YuRMo^txfRiK');
define('LOGGED_IN_SALT',   'r6C*Do`Huy;J/1 HdG1XK%|o9HroXhb[5RQ|3/>^5)r0pAt[FS2iwlm$qX]t|M@Z');
define('NONCE_SALT',       'C$t;dt@G_nv#0&rdK<}bM*)W-->aC{Ej$8+ezWv`:slDU`;-AeTFVvk{-6/pf8>2');

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
