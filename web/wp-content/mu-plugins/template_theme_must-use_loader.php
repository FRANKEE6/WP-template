<?php
/*
Plugin Name:    Template Theme MU plguin
Description:    This is a must use plugin
Version:        0.01
Author:         FRANKEE
Text Domain:    template-theme-MU-plugin
*/

/*
    U can use these wordpress constants for linking
WPMU_PLUGIN_DIR
WPMU_PLUGIN_URL
*/

/**
 *  Load translations
 */
add_action('plugins_loaded', 'template_theme_load_textdomain');
function template_theme_load_textdomain()
{
    load_plugin_textdomain('template-theme-MU-plugin');
}


/**
 *  Load most_viewed plugin
 * 
 *  This plugin creates new custom field for posts, tracking how many times post was viewed
 */
require_once WPMU_PLUGIN_DIR . '/inc/most_viewed_plugin/most_viewed_loader.php';


/**
 *  Load SEO_meta plugin
 */
require_once WPMU_PLUGIN_DIR . '/inc/SEO_meta_plugin/SEO_meta_loader.php';
