<?php
add_action('admin_menu', 'template_theme_relationships_menu');


function template_theme_relationships_menu()
{
    add_submenu_page('edit.php?post_type=tt_directors', 'Relationships', 'manage_options', 'tt_relationships', 'template_theme_relationships_options', 'dashicons-plus-alt2');
}


function template_theme_relationships_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    global $wpdb;
    echo '<div class="wrap">';
    echo '<p>Here is where the form would go if I actually had options.</p>';
    echo '<pre>';
    echo print_r($wpdb);
    echo '</pre>';
    echo '</div>';
}
