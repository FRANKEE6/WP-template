<?php

/**
 *  This folder is for functions that will work only this theme is active
 * 
 *  To make it more transparent, folder was split in subfiles 
 * 
 *  https://developer.wordpress.org/themes/basics/theme-functions/
 * 
 */


// Constatnts created so we do not need to call those functions again. 
define('THEME_DIRECTORY', get_theme_file_path());
define('THEME_DIRECTORY_URI', get_theme_file_uri());
define('TEMPLATE_DIRECTORY', get_template_directory());
define('TEMPLATE_DIRECTORY_URI', get_template_directory_uri());


/**
 *  Load my additional functions
 */
require_once THEME_DIRECTORY . '/inc/additional_functions.php';


/**
 *  Theme supports & page settings
 */
require_once THEME_DIRECTORY . '/inc/site-settings.php';


/**
 *  Load my scripts and styles
 */
require_once THEME_DIRECTORY . '/inc/scripts-and-styles.php';


/**
 *  Load my shortcodes
 */
require_once THEME_DIRECTORY . '/inc/shortcodes.php';


/**
 *  Load my widgets
 */
require_once THEME_DIRECTORY . '/inc/widgets.php';


/**
 *  Load my customizer expansions
 */
require_once THEME_DIRECTORY . '/inc/customizer_expansions.php';


/**
 *  Load code which remove all we do not need
 */
require_once THEME_DIRECTORY . '/inc/removals.php';
