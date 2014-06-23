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
define('DB_NAME', 'nancygoldring');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'g{P|-@$z|oF>t<d#|l7f9i=XF{RLa&vBY`|a[u_Q!zQA1?lO{tCuQDT(Q>}l*=9h');
define('SECURE_AUTH_KEY',  'Wb{5&Yc6/!Yn.&sydD*:+Qr7DjHYTC)K?+f|Si`sryD6?IkX9qh*iaoqQ1[t9nSz');
define('LOGGED_IN_KEY',    'lw/r)2w^$:c|H-fUCW%6*lGsO_:JzhM>{oP#q8pP|.$T_NLN?+ On^#8=k_@?!>R');
define('NONCE_KEY',        'e`QYy*OT(NrH(+c}ENPR#|<X56Fc0b*|RU$WxzUA]Z_@PUm^t?t:jJv<Z5NCC,ja');
define('AUTH_SALT',        'F<}*y6L,X%EBpqJ+7J)Sd3[G:(d$OB9<lb^A;ZH-|H$],a66@ydga!~bU B.Hk|t');
define('SECURE_AUTH_SALT', 'GInO^:c H_M_}L0v0)+6F%= HMB*eu2Y-LK9a})D%ym_}B?-k2g0i{tc*/:t8H5x');
define('LOGGED_IN_SALT',   'rt6il;iX||~U#YaH<Fe-[b8W+?e@>^+5#n|D8WzM4eO)tB|vSKB !5gUy:`&}%vH');
define('NONCE_SALT',       'b#-ta?jRAyf<E}~.&Eu)4HT3CY3F8o?Q/6(F#|PXU.=z#~a4AU81w^}dI-~B5cHz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
