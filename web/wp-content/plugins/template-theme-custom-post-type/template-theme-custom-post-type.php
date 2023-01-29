<?php
/*
Plugin Name: Template theme custom post type
Description: Just another custom pos type plugin
Author: FRANKEE
Text Domain: template-theme-custom-post-type
Domain Path: /languages/plugins
Version: 0.1
*/

// https://developer.wordpress.org/plugins/post-types/

define('TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN', __FILE__);
define('TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN_DIR', untrailingslashit(dirname(TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN)));

/**
 *  Load translations
 */
add_action('plugins_loaded', 'template_theme_custom_post_type_load_textdomain');
function template_theme_custom_post_type_load_textdomain()
{
    load_plugin_textdomain('template-theme-custom-post-type');
}


/**
 *  Load register functions for your custom post types
 */
require_once TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN_DIR . '/inc/custom_post_type_register.php';


/**
 *  Load core functionality of plugin
 */
require_once TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN_DIR . '/inc/custom_post_type_functions.php';


/**
 *  Load meta data and taxonomies
 */
require_once TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN_DIR . '/inc/custom_post_type_metas.php';


/**
 *  Load custom images for taxonomies
 */
require_once TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN_DIR . '/inc/custom_post_type_taxonomy_images.php';


/**
 *  Load custom menu relationships submenu page example
 */
require_once TEMPLATE_THEME_CUSTOM_POST_TYPE_PLUGIN_DIR . '/inc/custom_post_type_relationships.php';
