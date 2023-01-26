<?php

/**
 *  Adjust main query to do not retrieve posts but our custom post type
 * 
 *  Code is just example which can be used if just want to list our custom type on blog page
 *  In our scenario, we had to create new loop on ordinary page
 */
/* add_action('pre_get_posts', 'template_theme_custom_post_type_modify_main_query');
function template_theme_custom_post_type_modify_main_query($query)
{
    if ($query->is_page('films') && $query->is_main_query()) {
        $query->set('post_type', 'tt_movies');
    }
} */


/**
 *  Adjust main query on tag page to change post type to our custom post type
 * 
 *  While we use our custom taxonomy which is connected only to movies post type, we no longer need to set post_types on tt_movies
 * 
 *  Be advised that u must use it when u want to show your custom post type on page templates home, archive, single and singular
 */
/* add_action('pre_get_posts', 'template_theme_custom_post_type_modify_main_query');
function template_theme_custom_post_type_modify_main_query($query)
{
    if ($query->is_tag() && $query->is_main_query()) {
        $query->set('post_type', 'tt_movies');
    }
} */


/**
 *  Get SUM of gross values
 * 
 *  We will extrac ID's of posts from our custom query (if custom query is not set, use global $wp_query)
 */
function template_theme_total_gross()
{
    global $films_custom_query;
    global $wp_query;

    $query_in_use = [];

    if (isset($films_custom_query->posts)) {
        $query_in_use = $films_custom_query;
    } else {
        $query_in_use = $wp_query;
    }

    $ids = [];
    foreach ($query_in_use->posts as $post) {
        array_push($ids, $post->ID);
    }
    $ids = esc_sql($ids);
    $ids = implode(',', $ids);

    global $wpdb;

    $sum = $wpdb->get_var($wpdb->prepare("
        SELECT SUM(meta_value)
        FROM wp_postmeta
        WHERE post_id IN ($ids) AND meta_key = %s
        ", array(
        'tt_movie_gross',
    )));

    return intval($sum);
}
