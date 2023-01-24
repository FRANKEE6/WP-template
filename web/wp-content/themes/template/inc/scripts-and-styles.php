<?php

/**
 *  Enqueueing scripts and styles.
 * 
 *  https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * 
 *  https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * 
 */


/**
 *  Enqueuing theme styles
 */

function template_theme_enqueue_styles()
{
    // Normalize stylesheet
    wp_enqueue_style('normalize-style', TEMPLATE_DIRECTORY_URI . '/css/normalize.css', array());

    // Main stylesheet
    wp_enqueue_style('template_theme-style', TEMPLATE_DIRECTORY_URI . '/style.css', array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'template_theme_enqueue_styles');

/**
 *  Enqueuing theme scripts
 */

function template_theme_enqueue_scripts()
{
    wp_enqueue_script(
        'my-script',
        TEMPLATE_DIRECTORY_URI . '/js/custom.js',
        array('jquery'),
        false,
        true
    );
}
add_action('wp_enqueue_scripts', 'template_theme_enqueue_scripts');


/**
 *  Enqueuing admin styles
 * 
 *  This example shows how u can be more specific on which page u want to add your css or js
 *  Or use standard wp_enqueue_scripts hook to add it on every page
 * 
 *  https://developer.wordpress.org/reference/hooks/admin_print_styles-hook_suffix/
 * 
 *  For scripts use hook admin_print_scripts
 */

function template_theme_enqueue_admin_styles()
{
    wp_enqueue_style('template_theme_admin_style', TEMPLATE_DIRECTORY_URI . '/css/admin.css');
}
add_action('admin_print_styles-edit.php', 'template_theme_enqueue_admin_styles');
