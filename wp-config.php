<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'instantimmo');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'JNyxKZP/gp<+2ZL 7QyZ>3+J1y_>d@H}?@NnKA|,q/N&V`Hd+?X}8-Yw[n_xGPw#');
define('SECURE_AUTH_KEY',  ']4DBwpjU$8mvr74:m16{[EP_NK%tiY0e, 4d7$m W9`QJ6r%L|{krZZ4{}rvWoia');
define('LOGGED_IN_KEY',    '5O~v>?U7@fwhN`k(2YGyYCq)]s,gG`ThA{-9zO*{(E)6vYfVHW+3U)>UPo(^}V~W');
define('NONCE_KEY',        'Z%FxAq(w7A+v+SB4D-H~|ReKnVyQS56:5u?O{95V+5UV![;H[+CL8J%(6N~%+yq1');
define('AUTH_SALT',        'J6j+vJ+F$cLPh,rxD7@ygN]&]xEWd<V_hYR|@CDI$1+l(-+?X8qV}mnM/VV+oyF4');
define('SECURE_AUTH_SALT', 'v~D{L*#N$%e!b|6al2Yq4RS?,B!w8yM&%VUVCiYq_qfl.H01J2gwgw-|R<znl{PW');
define('LOGGED_IN_SALT',   'd9_b=cCjsaC1[85@-K#6#zA,(hYk%AzAh}+/_PU_%tp{,jX>5%IYtXot[,eD+jT>');
define('NONCE_SALT',       '-H|8A*5HrwBb%4!Pr}Mvl [L.sgm{PhL`kG<c++XJ4(nmd<z(N!${9*k+DjWKl<d');

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
