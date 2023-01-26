<?php

/**
 *  We will register our custom post type
 * 
 *  https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
 *  https://developer.wordpress.org/reference/functions/register_post_type/
 *  https://developer.wordpress.org/reference/functions/register_post_type/#user-contributed-notes
 * 
 *  Get menu icon options at
 *  https://developer.wordpress.org/resource/dashicons/
 */
add_action('init', 'template_theme_custom_post_type');
function template_theme_custom_post_type()
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
        'taxonomies'         => array('post_tag'),
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
        // Callback for our custom meta box
        'register_meta_box_cb' => 'template_theme_movie_meta_boxes',
    );

    register_post_type('tt_movies', $args);
}


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
 *  Movie meta box
 * 
 *  Function is called by when registering our post type above
 */
function template_theme_movie_meta_boxes()
{
    add_meta_box(
        'template-theme-movies-meta',
        __('More about this movie', 'template-theme-custom-post-type'),
        'template_theme_add_meta_box_callback',

    );
}


/**
 *  Adds metabox files and nonce field 
 */
function template_theme_add_meta_box_callback($post)
{
    wp_nonce_field(
        'template_theme_movie_meta_data',
        'template_theme_movie_meta_data_nonce'
    );

    $year = esc_attr(get_post_meta($post->ID, 'tt_movie_year', true));
    $gross = esc_attr(get_post_meta($post->ID, 'tt_movie_gross', true))
?>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="tt-year"><?= _x('Year of release', 'Year of film premiere', 'template-theme-custom-post-type') ?></label>
                </th>
                <td>
                    <input type="number" ID="tt-year" name="tt-year" value="<?= $year ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tt-gross"><?= _x('Worldwide gross', 'Wordwide gross of film', 'template-theme-custom-post-type') ?></label>
                </th>
                <td>
                    <input type="number" ID="tt-gross" name="tt-gross" value="<?= $gross ?>">
                    <?php if ($gross) : ?>
                        <span class="wp-ui-text-icon">
                            <?= number_format_i18n($gross) . ' $' ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>

<?php
}


/**
 *  At save, chceck nonce field and save data
 */
add_action('save_post', 'template_theme_movies_save_post');
function template_theme_movies_save_post($post_ID)
{
    if (!isset($_POST['template_theme_movie_meta_data_nonce']))
        return $post_ID;

    $nonce = $_POST['template_theme_movie_meta_data_nonce'];

    if (!wp_verify_nonce($nonce, 'template_theme_movie_meta_data'))
        return $post_ID;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_ID;

    $year = sanitize_text_field($_POST['tt-year']);
    $gross = sanitize_text_field($_POST['tt-gross']);

    update_post_meta($post_ID, 'tt_movie_year', $year);
    update_post_meta($post_ID, 'tt_movie_gross', $gross);
}


/**
 *  Get SUM of gross values
 * 
 *  We will extrac ID's of posts from our custom query (if u do not use custom query, use global $wp_query)
 */
function template_theme_total_gross()
{
    global $films_custom_query;

    if (!count($films_custom_query->posts)) return 0;

    $ids = [];
    foreach ($films_custom_query->posts as $post) {
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
