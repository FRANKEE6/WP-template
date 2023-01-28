<?php

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
        'template_theme_add_meta_box_callback_movies',
    );
}


/**
 *  Adds metabox files and nonce field 
 */
function template_theme_add_meta_box_callback_movies($post)
{
    wp_nonce_field(
        'template_theme_movie_meta_data',
        'template_theme_movie_meta_data_nonce'
    );

    $selected_director = esc_attr(get_post_meta($post->ID, 'tt_movie_director', true));
    $year = esc_attr(get_post_meta($post->ID, 'tt_movie_year', true));
    $gross = esc_attr(get_post_meta($post->ID, 'tt_movie_gross', true));
    $directors = get_posts(array(
        'post_type'     => 'tt_directors',
        'numberposts'   => -1,
        'order_by'      => 'post_title',
        'order'         => 'ASC',
    ));
?>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="tt-year"><?= _x('Year of release', 'Year of film premiere', 'template-theme-custom-post-type') ?></label>
                </th>
                <td>
                    <input type="number" ID="tt-year" name="tt-year" value="<?= esc_attr($year) ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tt-gross"><?= _x('Worldwide gross', 'Worldwide gross of film', 'template-theme-custom-post-type') ?></label>
                </th>
                <td>
                    <input type="number" ID="tt-gross" name="tt-gross" value="<?= esc_attr($gross) ?>">
                    <?php if ($gross) : ?>
                        <span class="wp-ui-text-icon">
                            <?= number_format_i18n($gross) . ' $' ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tt-director"><?= _x('Director', 'Director of this film', 'template-theme-custom-post-type') ?></label>
                </th>
                <td>
                    <select name="tt-director">
                        <option><?php _e('Select director from list', 'template-theme-cusom-post-type') ?></option>
                        <?php foreach ($directors as $director) : ?>
                            <option value="<?php echo $director->ID; ?>" <?php if ($selected_director == $director->ID) echo ' selected="selected"'; ?>><?php echo $director->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
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
    $selected_director = sanitize_text_field($_POST['tt-director']);

    update_post_meta($post_ID, 'tt_movie_year', $year);
    update_post_meta($post_ID, 'tt_movie_gross', $gross);
    update_post_meta($post_ID, 'tt_movie_director', $selected_director);
}


/**
 *  Register our new custom taxonomy genre for films
 * 
 *  https://developer.wordpress.org/plugins/taxonomies/working-with-custom-taxonomies/
 */
add_action('init', 'template_theme_register_taxonomy_genre');
function template_theme_register_taxonomy_genre()
{
    $labels = array(
        'name'              => _x('Genres', 'taxonomy general name', 'template-theme-custom-post-type'),
        'singular_name'     => _x('Genre', 'taxonomy singular name', 'template-theme-custom-post-type'),
        'search_items'      => __('Search Genres', 'template-theme-custom-post-type'),
        'all_items'         => __('All Genres', 'template-theme-custom-post-type'),
        'parent_item'       => __('Parent Genre', 'template-theme-custom-post-type'),
        'parent_item_colon' => __('Parent Genre:', 'template-theme-custom-post-type'),
        'edit_item'         => __('Edit Genre', 'template-theme-custom-post-type'),
        'update_item'       => __('Update Genre', 'template-theme-custom-post-type'),
        'add_new_item'      => __('Add New Genre', 'template-theme-custom-post-type'),
        'new_item_name'     => __('New Genre Name', 'template-theme-custom-post-type'),
        'menu_name'         => __('Genre', 'template-theme-custom-post-type'),
        'separate_items_with_commas' => __('Separate genres with commas', 'template-theme-custom-post-type'),
        'add_or_remove_items'       => __('Add or remove genres', 'template-theme-custom-post-type'),
        'choose_from_most_used'    => __('Choose from most used genres', 'template-theme-custom-post-type'),
    );
    $args   = array(
        'hierarchical'      => false, // make it hierarchical (like categories) on true
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'genre'),
    );

    register_taxonomy('genre', ['tt_movies'], $args);
}




//_____________________________________________________________________________________________________________________
/**
 *  director meta box
 * 
 *  Function is called by when registering our post type above
 */
function template_theme_director_meta_boxes()
{
    add_meta_box(
        'template-theme-directors-meta',
        __('More about this director', 'template-theme-custom-post-type'),
        'template_theme_add_meta_box_callback_directors',

    );
}


/**
 *  Adds metabox files and nonce field 
 */
function template_theme_add_meta_box_callback_directors($post)
{
    wp_nonce_field(
        'template_theme_director_meta_data',
        'template_theme_director_meta_data_nonce'
    );

    $date = esc_attr(get_post_meta($post->ID, 'tt_director_date', true));
?>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="tt-date"><?= _x('Birthdate', 'date of director birth', 'template-theme-custom-post-type') ?></label>
                </th>
                <td>
                    <input type="date" ID="tt-date" name="tt-date" value="<?= esc_attr($date) ?>">
                </td>
            </tr>
        </tbody>
    </table>

<?php
}


/**
 *  At save, chceck nonce field and save data
 */
add_action('save_post', 'template_theme_directors_save_post');
function template_theme_directors_save_post($post_ID)
{
    if (!isset($_POST['template_theme_director_meta_data_nonce']))
        return $post_ID;

    $nonce = $_POST['template_theme_director_meta_data_nonce'];

    if (!wp_verify_nonce($nonce, 'template_theme_director_meta_data'))
        return $post_ID;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_ID;

    $date = sanitize_text_field($_POST['tt-date']);

    update_post_meta($post_ID, 'tt_director_date', $date);
}


/**
 *  Register our new custom taxonomy country for directors
 * 
 *  https://developer.wordpress.org/plugins/taxonomies/working-with-custom-taxonomies/
 */
add_action('init', 'template_theme_register_taxonomy_country');
function template_theme_register_taxonomy_country()
{
    $labels = array(
        'name'              => _x('Countries', 'taxonomy general name', 'template-theme-custom-post-type'),
        'singular_name'     => _x('Country', 'taxonomy singular name', 'template-theme-custom-post-type'),
        'search_items'      => __('Search Countries', 'template-theme-custom-post-type'),
        'all_items'         => __('All Countries', 'template-theme-custom-post-type'),
        'parent_item'       => __('Parent Country', 'template-theme-custom-post-type'),
        'parent_item_colon' => __('Parent Country:', 'template-theme-custom-post-type'),
        'edit_item'         => __('Edit Country', 'template-theme-custom-post-type'),
        'update_item'       => __('Update Country', 'template-theme-custom-post-type'),
        'add_new_item'      => __('Add New Country', 'template-theme-custom-post-type'),
        'new_item_name'     => __('New Country Name', 'template-theme-custom-post-type'),
        'menu_name'         => __('Country', 'template-theme-custom-post-type'),
        'separate_items_with_commas' => __('Separate countries with commas', 'template-theme-custom-post-type'),
        'add_or_remove_items'       => __('Add or remove countries', 'template-theme-custom-post-type'),
        'choose_from_most_used'    => __('Choose from most used countries', 'template-theme-custom-post-type'),
    );
    $args   = array(
        'hierarchical'      => false, // make it hierarchical (like categories) on true
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'country'),
    );

    register_taxonomy('country', ['tt_directors'], $args);
}
