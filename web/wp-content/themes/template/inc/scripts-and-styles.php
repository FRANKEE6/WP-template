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
 *  Enqueuing styles
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
 *  Enqueuing scripts
 */

function template_theme_enqueue_scripts()
{
    wp_enqueue_script(
        'my-script',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array('jquery'),
        false,
        true
    );
}
add_action('wp_enqueue_scripts', 'template_theme_enqueue_scripts');
