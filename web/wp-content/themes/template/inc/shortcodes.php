<?php

/**
 *  Shortcodes
 * 
 *  https://codex.wordpress.org/Shortcode
 * 
 *  https://developer.wordpress.org/plugins/shortcodes/
 */

// This will add <i> element whis show my scroll up button
add_shortcode('scrollup', 'template_theme_scrollup_button_handler');
function template_theme_scrollup_button_handler()
{
    $content = '<i class="fa-solid fa-angles-up scrlup"></i>';

    return apply_filters('the_content', $content);
}
