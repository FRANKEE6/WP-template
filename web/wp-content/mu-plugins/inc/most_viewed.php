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

        add_post_meta($post_ID, 'post_view_count', '0', true);
    }
}


add_action('get_footer', 'template_theme_save_post_view_count');
function template_theme_save_post_view_count()
{
    if (is_single()) {
        echo '<pre>';
        var_dump(template_theme_add_post_view_count());
        echo '</pre>';
    }
}


function template_theme_get_post_view_count($post_ID = false)
{
    if (!$post_ID) {
        $post_ID = get_post_field('ID', get_post());
    }

    $field = 'post_view_count';
    $count = get_post_meta($post_ID, $field, true);

    if (!$count) {
        delete_post_meta($post_ID, $field);
        add_post_meta($post_ID, $field, '0');
    }


    return (int) $count;
}


function template_theme_add_post_view_count($post_ID = false)
{
    if (!$post_ID) {
        $post_ID = get_the_ID();
    }

    $field = 'post_view_count';
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
