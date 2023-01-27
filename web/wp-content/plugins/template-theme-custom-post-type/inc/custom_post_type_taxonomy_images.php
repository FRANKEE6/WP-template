<?php

define('CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER', plugins_url('/img/placeholder.png', __FILE__));

add_action('admin_init', 'custom_post_type_ti_init');
function custom_post_type_ti_init()
{
    $ti_taxonomies = get_taxonomies();
    if (is_array($ti_taxonomies)) {
        $ti_options = get_option('ti_options');

        if (!is_array($ti_options))
            $ti_options = array();

        if (empty($ti_options['excluded_taxonomies']))
            $ti_options['excluded_taxonomies'] = array();

        foreach ($ti_taxonomies as $ti_taxonomy) {
            if (in_array($ti_taxonomy, $ti_options['excluded_taxonomies']))
                continue;
            add_action($ti_taxonomy . '_add_form_fields', 'tiAddTexonomyField');
            add_action($ti_taxonomy . '_edit_form_fields', 'tiEditTexonomyField');
            add_filter('manage_edit-' . $ti_taxonomy . '_columns', 'tiTaxonomyColumns');
            add_filter('manage_' . $ti_taxonomy . '_custom_column', 'tiTaxonomyColumn', 10, 3);

            // If tax is deleted
            add_action("delete_{$ti_taxonomy}", function ($tt_id) {
                delete_option('ti_taxonomy_image' . $tt_id);
            });
        }
    }
    // Register settings
    register_setting('ti_options', 'ti_options');
    add_settings_section('ti_settings', __('Tag Images settings', 'template-theme-custom-post-type'), 'tiSectionText', 'ti-options');
    add_settings_field('ti_excluded_taxonomies', __('Excluded Taxonomies', 'template-theme-custom-post-type'), 'tiExcludedTaxonomies', 'ti-options', 'ti_settings');
}


// Settings section description
function tiSectionText()
{
    echo '<p>' . __('Please select the taxonomies you want to exclude it from Categories Images plugin', 'template-theme-custom-post-type') . '</p>';
}


// Excluded taxonomies checkboxs
function tiExcludedTaxonomies()
{
    $options = get_option('ti_options');
    $disabled_taxonomies = ['nav_menu', 'link_category', 'post_format'];
    foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue; ?>
        <input type="checkbox" name="ti_options[excluded_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked(isset($options['excluded_taxonomies'][$tax])); ?> /> <?php echo $tax; ?><br />
    <?php endforeach;
}


// add image field in add form
function tiAddTexonomyField()
{

    wp_enqueue_style('thickbox');
    wp_enqueue_script('thickbox');


    echo '<div class="form-field">
            <label for="tiz_taxonomy_image">' . __('Image', 'template-theme-custom-post-type') . '</label>
            <input type="text" name="tiz_taxonomy_image" id="tiz_taxonomy_image" value="" />
            <br/>
            <button class="ti_upload_image_button button">' . __('Upload/Add image', 'template-theme-custom-post-type') . '</button>
        </div>';
}


// add image field in edit form
function tiEditTexonomyField($taxonomy)
{

    wp_enqueue_style('thickbox');
    wp_enqueue_script('thickbox');


    if (tiTaxonomyImageUrl($taxonomy->term_id, NULL, TRUE) == CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER)
        $image_url = "";
    else
        $image_url = tiTaxonomyImageUrl($taxonomy->term_id, NULL, TRUE);
    echo '<tr class="form-field">
            <th scope="row" valign="top"><label for="tiz_taxonomy_image">' . __('Image', 'template-theme-custom-post-type') . '</label></th>
            <td><img class="ti-taxonomy-image" src="' . tiTaxonomyImageUrl($taxonomy->term_id, 'medium', TRUE) . '"/><br/><input type="text" name="tiz_taxonomy_image" id="tiz_taxonomy_image" value="' . $image_url . '" /><br />
            <button class="ti_upload_image_button button">' . __('Upload/Add image', 'template-theme-custom-post-type') . '</button>
            <button class="ti_remove_image_button button">' . __('Remove image', 'template-theme-custom-post-type') . '</button>
            </td>
        </tr>';
}


// get taxonomy image url for the given term_id (Place holder image by default)
function tiTaxonomyImageUrl($term_id = NULL, $size = 'full', $return_placeholder = FALSE)
{
    if (!$term_id) {
        if (is_category())
            $term_id = get_query_var('cat');
        elseif (is_tag())
            $term_id = get_query_var('tag_id');
        elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $term_id = $current_term->term_id;
        }
    }

    $taxonomy_image_url = get_option('ti_taxonomy_image' . $term_id);
    if (!empty($taxonomy_image_url)) {
        $attachment_id = tiGetAttachmentIdByUrl($taxonomy_image_url);
        if (!empty($attachment_id)) {
            $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
            $taxonomy_image_url = $taxonomy_image_url[0];
        }
    }

    if ($return_placeholder)
        return ($taxonomy_image_url != '') ? $taxonomy_image_url : CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER;
    else
        return $taxonomy_image_url;
}


// get attachment ID by image url
function tiGetAttachmentIdByUrl($image_src)
{
    global $wpdb;
    $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}


/**
 * Thumbnail column added to category admin.
 */
function tiTaxonomyColumns($columns)
{
    if (!empty($columns)) {

        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['thumb'] = __('Image', 'template-theme-custom-post-type');

        unset($columns['cb']);

        return array_merge($new_columns, $columns);
    }
}


/**
 * Thumbnail column value added to category admin.
 */
function tiTaxonomyColumn($columns, $column, $id)
{
    if ($column == 'thumb')
        $columns = '<span><img src="' . tiTaxonomyImageUrl($id, 'thumbnail', TRUE) . '" alt="' . __('Thumbnail', 'template-theme-custom-post-type') . '" class="wp-post-image" /></span>';

    return $columns;
}


// Plugin menu in admin panel
add_action('admin_menu', 'tiSettingsMenu');
function tiSettingsMenu()
{
    add_menu_page(__('Taxonomy Images settings', 'template-theme-custom-post-type'), __('Taxonomy Images', 'template-theme-custom-post-type'), 'manage_options', 'ti_settings', 'tiSettingsPage', 'dashicons-format-image', 80);
}

// Plugin option page
function tiSettingsPage()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'template-theme-custom-post-type'));
    }
    ?>
    <div class="wrap">
        <h2><?php _e('Taxonomy Images', 'taxonomies-images'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('ti_options'); ?>
            <?php do_settings_sections('ti-options'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}


// save our taxonomy image while edit or create term
add_action('edit_term', 'tiSaveTaxonomyImage');
add_action('create_term', 'tiSaveTaxonomyImage');

function tiSaveTaxonomyImage($term_id)
{
    if (isset($_POST['tiz_taxonomy_image'])) {
        update_option('ti_taxonomy_image' . $term_id, $_POST['tiz_taxonomy_image'], false);
    }
}


// Register script
if (strpos($_SERVER['SCRIPT_NAME'], 'edit-tags.php') > 0 || strpos($_SERVER['SCRIPT_NAME'], 'term.php') > 0) {
    add_action('admin_enqueue_scripts', 'tiAdminEnqueue');
}

function tiAdminEnqueue()
{
    wp_enqueue_script('categories-images-scripts', plugins_url('/js/ti-scripts.js', __FILE__));

    $ti_js_config = [
        'wordpress_ver' => get_bloginfo("version"),
        'placeholder' => CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER,
    ];
    wp_localize_script('categories-images-scripts', 'ti_config', $ti_js_config);
}
