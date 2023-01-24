<?php

/**
 *  This section will automatically add new post_meta named view_count upon pusblishing post
 *  view_count will hold integer value representing how many time this post was viewed
 * 
 *  https://developer.wordpress.org/reference/functions/add_post_meta/
 */

add_action('publish_post', 'template_theme_add_custom_field_post_view_count');

function template_theme_add_custom_field_post_view_count($post_ID)
{

    if (!wp_is_post_revision($post_ID)) {

        // If u name your custom field starting with '_' wordpress will hide it in admin dashboard so the user can't modify those data
        add_post_meta($post_ID, '_post_view_count', '0', true);
    }
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
 *  This function automaticly increases meta value of post_view_count
 * 
 *  Yet again if value can't be retrieved, we will create it
 */

function template_theme_add_post_view_count($post_ID = false)
{
    if (!$post_ID) {
        $post_ID = get_the_ID();
    }

    $field = '_post_view_count';
    $count = get_post_meta($post_ID, $field, true);

    if (!$count) {
        $count = 0;
        delete_post_meta($post_ID, $field);
        add_post_meta($post_ID, $field, $count);
    }

    (int) $count++;

    update_post_meta($post_ID, $field, $count);

    return $count;
}


/**
 *  Upon viewing a single post we will fire a function to increase view count
 * 
 *  Notice we are hooking onto get_footer to make sure the post was visible before we add value
 */
add_action('get_footer', 'template_theme_save_post_view_count');
function template_theme_save_post_view_count()
{
    if (is_single()) {
        template_theme_add_post_view_count();
    }
}


/**
 *  We will add views column for post in admin dashboard
 * 
 *  https://developer.wordpress.org/reference/hooks/manage_posts_columns/
 */

add_filter('manage_posts_columns', 'template_theme_add_post_views_column');
function template_theme_add_post_views_column($columns)
{
    // U can also use unset to delete some columns
    unset($columns['author']);

    $columns['views'] = __('Views', 'template_theme');

    return $columns;
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

add_filter('manage_edit-post_sortable_columns', 'teamplate_theme_add_sortable_views_column');
function teamplate_theme_add_sortable_views_column($columns)
{
    $columns['views'] = __('views', 'template_theme');

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
