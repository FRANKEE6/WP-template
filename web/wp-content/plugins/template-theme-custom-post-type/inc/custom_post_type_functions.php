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

    // We need to determine which query is being used
    if (isset($films_custom_query->posts)) {
        $query_in_use = $films_custom_query;
    } else {
        $query_in_use = $wp_query;
    }

    // Extract ids from query posts into array
    $ids = [];
    foreach ($query_in_use->posts as $post) {
        array_push($ids, $post->ID);
    }
    // Escape our data for safe sql usage
    $ids = esc_sql($ids);
    // implode array to string as sql preprare do not accept arrays
    $ids = implode(',', $ids);

    global $wpdb;

    // There we prepare our query and fire it. Query will return sum of meta_values from posts with IDs we input
    $sum = $wpdb->get_var($wpdb->prepare("
        SELECT SUM(meta_value)
        FROM wp_postmeta
        WHERE post_id IN ($ids) AND meta_key = %s
        ", array(
        'tt_movie_gross',
    )));

    // We want to get integer so we cast intval to make sure we get one
    return intval($sum);
}



/**
 *  Retrieve posts from query by filters in $_GET
 */
function template_theme_add_custom_country_filter_option($query)
{
    global $pagenow;

    // Define which post type we want to filter
    $type = 'tt_directors';

    // If there is no post_type definet in GET, stop code
    if (!isset($_GET['post_type'])) {
        return;
    }
    // If post type is not our type, stop code
    if ($_GET['post_type'] != $type) {
        return;
    }
    // If page is edit.php and our filters are set in GET while they are not an empty string, retrieve these posts from query
    if ('edit.php' == $pagenow && isset($_GET['country_filter']) && $_GET['country_filter'] != '') {
        $query->query_vars['tax_query'] = array(
            array(
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $_GET['country_filter'],
            ),
        );
    }
}
add_filter('parse_query', 'template_theme_add_custom_country_filter_option');


/**
 *  Create our custom country filter select on director post type page
 */
function template_theme_add_custom_country_filter()
{
    // Define which post type we want to filter
    $type = 'tt_directors';

    // If there is no post_type definet in GET, stop code
    if (!isset($_GET['post_type'])) {
        return;
    }
    // If post type is not our type, stop code
    if ($_GET['post_type'] != $type) {
        return;
    }

    // Define which taxonomy will be used for filtering and retrieve them from database
    $taxonomy = 'country';
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ));

    // This filtering saves into array only values we need
    $values = array();
    foreach ($terms as $term) {
        $values[$term->name] = $term->slug;
    }

    // There goes HTML output
?>
    <select name="country_filter">
        <option value=""><?php _e('Filter By country', 'template-theme-custom-post-type'); ?></option>
        <?php
        // If we do filter our data, save get value into variable
        $current_v = isset($_GET['country_filter']) ? $_GET['country_filter'] : '';
        // For each of our values create separate option tag
        // If value is same as current filter, mark it as selected
        foreach ($values as $label => $value) {
            printf(
                '<option value="%s"%s>%s</option>',
                $value,
                $value == $current_v ? ' selected="selected"' : '',
                $label
            );
        }
        ?>
    </select>
<?php
}

add_action('restrict_manage_posts', 'template_theme_add_custom_country_filter');
