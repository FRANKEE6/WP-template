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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'WP_template' );

/** Database username */
define( 'DB_USER', 'FRANKEE' );

/** Database password */
define( 'DB_PASSWORD', '8EE2pknk' );

/** Database hostname */
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
define( 'AUTH_KEY',         'lT2p,df3Co3Fa46{})l4EUt-S3KZ6sC%:WyFHTRf%1)9[|+K_dUa&/Yc!_(`sp#k' );
define( 'SECURE_AUTH_KEY',  '|H3=[-t{3c*oc6|_~PW5tI  VHqfZs6:{52v2:OrN1|w7!-j%ONxm{Rg;4MpZtU5' );
define( 'LOGGED_IN_KEY',    'X.P68s6=Ah%b*RRee7`(Kh2yF^uW?! 6!+4*&qwij:77hs,y>q!(!MW`%C6#zhlR' );
define( 'NONCE_KEY',        'V>?td^fsdD79&;/~X nWUvg#eoamPv0A%ad#CUt{ 46@H7gA.{]J92!pZKE(g(mQ' );
define( 'AUTH_SALT',        'Nu}R?xMX7Dwh,3[PSI-u^>!3Mb{(j&h-FhDN?[*@x:]7^Q=6IaOYVcH*[F[HyT=J' );
define( 'SECURE_AUTH_SALT', 'opzU U2o;z;FTeK8MVpL;$.J&r<kBU/hb3m.fQt[#[#ZHD[mrF@UACV a-mBTMUY' );
define( 'LOGGED_IN_SALT',   'G_{p](F)7&c.,#eLqBc|pV./&>T)N6P3%={/Nzecg#$gkowt;YcuhE7I$M@r2~I8' );
define( 'NONCE_SALT',       '_[~)&s_<2%}6dJO^:yPUlq:&whY!l#-/Q3R[X+i*g:$a@p;.z8DZ5l}7O?F>hDyR' );

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
