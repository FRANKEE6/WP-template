<?php

/**
 *  We will add views column for post in admin dashboard
 * 
 *  https://developer.wordpress.org/reference/hooks/manage_posts_columns/
 */

// We can also use for cycle to fire our function for more different hooks. This is used for our custom post types
foreach (array('post', 'tt_movies', 'tt_directors') as $screen) {
    $screen = ($screen == 'post') ? '' : $screen . '_';

    add_filter("manage_{$screen}posts_columns", 'template_theme_add_post_views_column');
}
function template_theme_add_post_views_column($columns)
{
    // U can also use unset to delete some columns
    unset($columns['author']);

    $columns['views'] = __('Views', 'template-theme-MU-plugin');

    return $columns;
}


/**
 *  This function retrieves value of post_view_count
 * 
 *  If value can't be retrieved (coz it doesn't exists), we will create it
 */

function template_theme_get_post_view_count($post_ID = false)
{
    if (!$post_ID) {
        $post_ID = get_post_field('ID', get_post());
    }

    $field = '_post_view_count';
    $count = get_post_meta($post_ID, $field, true);

    if (!$count) {
        delete_post_meta($post_ID, $field);
        add_post_meta($post_ID, $field, '0');
    }


    return (int) $count;
}


/**
 *  Populate the 'views' column
 * 
 *  https://developer.wordpress.org/reference/hooks/manage_posts_columns/
 */

add_action('manage_posts_custom_column', 'template_theme_add_post_views_data', 10, 2);
function template_theme_add_post_views_data($column, $post_ID)
{
    if ($column === 'views') {
        echo template_theme_get_post_view_count($post_ID);
    }
}


/**
 *  Make 'views' column sortable
 */
foreach (array('post', 'tt_movies', 'tt_directors') as $screen) {
    add_filter("manage_edit-{$screen}_sortable_columns", 'teamplate_theme_add_sortable_views_column');
}
function teamplate_theme_add_sortable_views_column($columns)
{
    $columns['views'] = __('views', 'template-theme-MU-plugin');

    return ($columns);
}


/**
 *  Order by 'views' column
 * 
 *  Make sure values are ordered as numeric
 * 
 *  We are hooking before Query is fired so we can edit it
 */

add_action('pre_get_posts', 'template_theme_views_column_orderby');
function template_theme_views_column_orderby($query)
{
    if (!is_admin()) {
        return;
    }
    $orderby = $query->get('orderby');
    if ('views' == $orderby) {
        $query->set('meta_key', '_post_view_count');
        $query->set('orderby', 'meta_value_num');
    }
}


/**
 *  Enqueuing admin styles for views column
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
    wp_enqueue_style('template_theme_admin_style', TEMPLATE_THEME_MOST_VIEWED_PLUGIN_URL . '/admin/admin.css');
}
add_action('admin_print_styles-edit.php', 'template_theme_enqueue_admin_styles');
