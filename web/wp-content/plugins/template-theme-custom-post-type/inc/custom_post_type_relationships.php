<?php

/**
 *  This way u can add new pages or submenu pages. Check links bellow
 * 
 *  https://developer.wordpress.org/reference/functions/add_menu_page/
 *  https://developer.wordpress.org/reference/functions/add_submenu_page/
 */
add_action('admin_menu', 'template_theme_relationships_menu');
function template_theme_relationships_menu()
{
    add_submenu_page('edit.php?post_type=tt_directors', 'Relationships', 'Relationships', 'manage_options', 'tt_relationships', 'template_theme_relationships_options');
}


/**
 *  This function is called by callback when page is created
 * 
 *  This is the place where u echo HTML output for your admin menu/submenu
 */
function template_theme_relationships_options()
{
    // U can define which user can enter this menu/submenu
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'template-theme-custom-post-type'));
    }

    echo '<h1>';
    _e('Hello there!', 'template-theme-custom-post-type');
    echo '</h1>';

    echo '<p>';
    _e('This is just example page. But with little love, u can recreate it to make awesome stuff, like create settings for your plugins which can by managed from this very page.', 'template-theme-custom-post-type');
    echo '</p>';
}
