<?php

/**
 *  We will register our custom post type for films
 * 
 *  https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 *  https://developer.wordpress.org/reference/functions/register_post_type/#user-contributed-notes
 * 
 *  Get menu icon options at
 *  https://developer.wordpress.org/resource/dashicons/
 */
add_action('init', 'template_theme_custom_post_type_film');
function template_theme_custom_post_type_film()
{
    $labels = array(
        'name'                  => _x('Movies', 'Post type general name', 'template-theme-custom-post-type'),
        'singular_name'         => _x('Movie', 'Post type singular name', 'template-theme-custom-post-type'),
        'menu_name'             => _x('Movies', 'Admin Menu text', 'template-theme-custom-post-type'),
        'name_admin_bar'        => _x('Movie', 'Add New on Toolbar', 'template-theme-custom-post-type'),
        'add_new'               => __('Add New', 'template-theme-custom-post-type'),
        'add_new_item'          => __('Add New Movie', 'template-theme-custom-post-type'),
        'new_item'              => __('New Movie', 'template-theme-custom-post-type'),
        'edit_item'             => __('Edit Movie', 'template-theme-custom-post-type'),
        'view_item'             => __('View Movie', 'template-theme-custom-post-type'),
        'all_items'             => __('All Movies', 'template-theme-custom-post-type'),
        'search_items'          => __('Search Movies', 'template-theme-custom-post-type'),
        'parent_item_colon'     => __('Parent Movies:', 'template-theme-custom-post-type'),
        'not_found'             => __('No Movies found.', 'template-theme-custom-post-type'),
        'not_found_in_trash'    => __('No Movies found in Trash.', 'template-theme-custom-post-type'),
        'featured_image'        => _x('Movie Poster', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'set_featured_image'    => _x('Set movie poster', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'remove_featured_image' => _x('Remove movie poster', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'use_featured_image'    => _x('Use as movie poster', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'archives'              => _x('Movie archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'template-theme-custom-post-type'),
        'insert_into_item'      => _x('Insert into Movie', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'template-theme-custom-post-type'),
        'uploaded_to_this_item' => _x('Uploaded to this Movie', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'template-theme-custom-post-type'),
        'filter_items_list'     => _x('Filter Movies list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'template-theme-custom-post-type'),
        'items_list_navigation' => _x('Movies list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'template-theme-custom-post-type'),
        'items_list'            => _x('Movies list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'template-theme-custom-post-type'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'movie'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-editor-video',
        // We can substitue post_tag with our custom taxonomy
        //'taxonomies'         => array('post_tag'),
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
        // Callback for our custom meta box
        'register_meta_box_cb' => 'template_theme_movie_meta_boxes',
    );

    register_post_type('tt_movies', $args);
}


/**
 *  We will register our custom post type for directors
 * 
 *  https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 *  https://developer.wordpress.org/reference/functions/register_post_type/#user-contributed-notes
 * 
 *  Get menu icon options at
 *  https://developer.wordpress.org/resource/dashicons/
 */
add_action('init', 'template_theme_custom_post_type_director');
function template_theme_custom_post_type_director()
{
    $labels = array(
        'name'                  => _x('Directors', 'Post type general name', 'template-theme-custom-post-type'),
        'singular_name'         => _x('Director', 'Post type singular name', 'template-theme-custom-post-type'),
        'menu_name'             => _x('Directors', 'Admin Menu text', 'template-theme-custom-post-type'),
        'name_admin_bar'        => _x('Director', 'Add New on Toolbar', 'template-theme-custom-post-type'),
        'add_new'               => __('Add New', 'template-theme-custom-post-type'),
        'add_new_item'          => __('Add New Director', 'template-theme-custom-post-type'),
        'new_item'              => __('New Director', 'template-theme-custom-post-type'),
        'edit_item'             => __('Edit Director', 'template-theme-custom-post-type'),
        'view_item'             => __('View Director', 'template-theme-custom-post-type'),
        'all_items'             => __('All Directors', 'template-theme-custom-post-type'),
        'search_items'          => __('Search Directors', 'template-theme-custom-post-type'),
        'parent_item_colon'     => __('Parent Directors:', 'template-theme-custom-post-type'),
        'not_found'             => __('No Directors found.', 'template-theme-custom-post-type'),
        'not_found_in_trash'    => __('No Directors found in Trash.', 'template-theme-custom-post-type'),
        'featured_image'        => _x('Director Poster', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'set_featured_image'    => _x('Set director photo', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'remove_featured_image' => _x('Remove director photo', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'use_featured_image'    => _x('Use as director photo', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'template-theme-custom-post-type'),
        'archives'              => _x('Director archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'template-theme-custom-post-type'),
        'insert_into_item'      => _x('Insert into Director', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'template-theme-custom-post-type'),
        'uploaded_to_this_item' => _x('Uploaded to this Director', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'template-theme-custom-post-type'),
        'filter_items_list'     => _x('Filter Directors list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'template-theme-custom-post-type'),
        'items_list_navigation' => _x('Directors list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'template-theme-custom-post-type'),
        'items_list'            => _x('Directors list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'template-theme-custom-post-type'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'director'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => array('title', 'thumbnail'),
        // Callback for our custom meta box
        'register_meta_box_cb' => 'template_theme_director_meta_boxes',
    );

    register_post_type('tt_directors', $args);
}
