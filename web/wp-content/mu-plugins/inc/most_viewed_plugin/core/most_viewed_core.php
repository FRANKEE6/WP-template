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
