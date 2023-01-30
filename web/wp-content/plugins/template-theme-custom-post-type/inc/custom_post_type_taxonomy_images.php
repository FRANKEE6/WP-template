<?php

/**
 *  This code allows you to add image to some taxonomy
 * 
 *  There is also included settings page in admin menu where user can define for himself which taxonomies can have image
 */

// Define constant to file containing our placeholder
define('CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER', plugins_url('/img/placeholder.png', __FILE__));


// This action set will be fired in admin menu init event
add_action('admin_init', 'custom_post_type_ti_init');
function custom_post_type_ti_init()
{
    // Get all taxonomies in use
    $ti_taxonomies = get_taxonomies();

    // If some taxonomies were found, retrieve our options from database. Else only create options page so options can be set by user
    if (is_array($ti_taxonomies)) {
        $ti_options = get_option('ti_options');

        // If our options do not contain anything, make them an empty array
        if (!is_array($ti_options))
            $ti_options = array();

        // If our options do not have any excluded taxonomies, yet again create an empty array in excluded_taxonomies array
        if (empty($ti_options['excluded_taxonomies']))
            $ti_options['excluded_taxonomies'] = array();

        // Now loop trough our list of taxonomies
        foreach ($ti_taxonomies as $ti_taxonomy) {
            // If currently looped taxonomy is found in array of excluded taxonomies, skip this iteration to next
            if (in_array($ti_taxonomy, $ti_options['excluded_taxonomies']))
                continue;

            // For all taxonomies which are not excluded, there actions will be executed
            add_action($ti_taxonomy . '_add_form_fields', 'tiAddTexonomyField');
            add_action($ti_taxonomy . '_edit_form_fields', 'tiEditTexonomyField');
            add_filter('manage_edit-' . $ti_taxonomy . '_columns', 'tiTaxonomyColumns');
            add_filter('manage_' . $ti_taxonomy . '_custom_column', 'tiTaxonomyColumn', 10, 3);

            // If taxonomy is deleted, delete their image too
            add_action("delete_{$ti_taxonomy}", function ($tt_id) {
                delete_option('ti_taxonomy_image' . $tt_id);
            });
        }
    }
    // Register settings page
    register_setting('ti_options', 'ti_options');
    // Create content of page (notice that function has callback to another function)
    add_settings_section('ti_settings', __('Tax Images settings', 'template-theme-custom-post-type'), 'tiSectionText', 'ti-options');
    // Now add field to our section (notice that function has callback to another function)
    add_settings_field('ti_excluded_taxonomies', __('Excluded Taxonomies', 'template-theme-custom-post-type'), 'tiExcludedTaxonomies', 'ti-options', 'ti_settings');
}


// Settings section description (function is fired as callback of add_setting_section)
function tiSectionText()
{
    echo '<p>' . __('Please select the taxonomies you want to exclude it from Taxonomy Images plugin', 'template-theme-custom-post-type') . '</p>';
}


// Excluded taxonomies checkboxs (function is fired as callback of add_setting_field)
function tiExcludedTaxonomies()
{
    // Get our options from database
    $options = get_option('ti_options');
    // Define taxonomies that will be always disabled
    $disabled_taxonomies = ['nav_menu', 'link_category', 'post_format'];

    // Get all registered taxonomies and loop through them.
    // If iterated taxonomy is found in array of disabled taxonomies, iteration will be skipped to next one
    // For all allowed taxonomies an checkbox imput field will be reated
    // We also chceck if iterated taxonomy is in array of excluded taxonomies. If true, chcecked attribute will be added to imput
    foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue; ?>
        <input type="checkbox" name="ti_options[excluded_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked(isset($options['excluded_taxonomies'][$tax])); ?> /> <?php echo $tax; ?><br />
    <?php endforeach;
}


// Add image field in add form for taxonomy
function tiAddTexonomyField()
{
    echo '<div class="form-field">
            <label for="tiz_taxonomy_image">' . __('Image', 'template-theme-custom-post-type') . '</label>
            <input type="text" name="tiz_taxonomy_image" id="tiz_taxonomy_image" value="" />
            <br/>
            <button class="ti_upload_image_button button">' . __('Upload/Add image', 'template-theme-custom-post-type') . '</button>
        </div>';
}


// Get taxonomy image url for the given term_id (Placeholder image by default)
function tiTaxonomyImageUrl($term_id = NULL, $size = 'full', $return_placeholder = FALSE)
{
    // If not term ID wass passed to function, we will try to retrieve it
    if (!$term_id) {

        // If we are editing category, get id of it
        if (is_category())
            $term_id = get_query_var('cat');

        // If we are editing tag, get id of it
        elseif (is_tag())
            $term_id = get_query_var('tag_id');

        // If we are editing taxonomy, get id of it
        elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            // From array retrieved we will extract id of term
            $term_id = $current_term->term_id;
        }
    }

    // We will try to retrieve image if there is any set
    $taxonomy_image_url = get_option('ti_taxonomy_image' . $term_id);

    // Check if retrieval was successful
    if (!empty($taxonomy_image_url)) {
        // If not, we will call function to retrieve ID of element which has this url set
        $attachment_id = tiGetAttachmentIdByUrl($taxonomy_image_url);

        // If we succeeded in ID retrieval, we will retrieve attached image to this id and set it to first option from array
        if (!empty($attachment_id)) {
            $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
            $taxonomy_image_url = $taxonomy_image_url[0];
        }
    }

    // If true was passed into function for $return_placeholder, we will chceck our url if is not empty.
    // If not empty, return it, otherwise return our constant with url to placeholder image
    if ($return_placeholder)
        return ($taxonomy_image_url != '') ? $taxonomy_image_url : CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER;
    else
        // If $return_placeholer was not set to true, just return anything in $taxonomy_image_url
        return $taxonomy_image_url;
}


// Add image field in edit form for taxonomy
function tiEditTexonomyField($taxonomy)
{
    // Try to retrieve image url set. If placeholder ulr is returned, set our variable to empty string
    if (tiTaxonomyImageUrl($taxonomy->term_id, NULL, TRUE) == CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER)
        $image_url = "";

    // Else save retrieved url path to image into our vaiable
    else
        $image_url = tiTaxonomyImageUrl($taxonomy->term_id, NULL, TRUE);

    // Now create a table to display image and with upload and remove buttons (these buttons are triggering JavaScript functions)
    echo '<tr class="form-field">
            <th scope="row" valign="top"><label for="tiz_taxonomy_image">' . __('Image', 'template-theme-custom-post-type') . '</label></th>
            <td><img class="ti-taxonomy-image" src="' . tiTaxonomyImageUrl($taxonomy->term_id, 'medium', TRUE) . '"/><br/><input type="text" name="tiz_taxonomy_image" id="tiz_taxonomy_image" value="' . $image_url . '" /><br />
            <button class="ti_upload_image_button button">' . __('Upload/Add image', 'template-theme-custom-post-type') . '</button>
            <button class="ti_remove_image_button button">' . __('Remove image', 'template-theme-custom-post-type') . '</button>
            </td>
        </tr>';
}


// This function helps to retrieve ID of term using attached image url
function tiGetAttachmentIdByUrl($image_src)
{
    global $wpdb;

    // We will prepare sql to extract our ID
    $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);

    // We will extract our ID tranks to query
    $id = $wpdb->get_var($query);

    // If our id is not empty, return it. Otherwise return NULL
    return (!empty($id)) ? $id : NULL;
}


/**
 *  Thumbnail column added by filter upon managing taxonomy in admin
 */
function tiTaxonomyColumns($columns)
{
    // If columns were successfully retrieved
    if (!empty($columns)) {

        // Create array of our new columns
        $new_columns = array();
        // Resave 'cb' column into our new columns array (We need to do this to ensure 'cb' column will be first column displayed)
        $new_columns['cb'] = $columns['cb'];
        // Add our custom column in new columns array
        $new_columns['thumb'] = __('Image', 'template-theme-custom-post-type');

        // unset 'cb' column from original array so we do not have it twice
        unset($columns['cb']);

        // Merge our arrays into one and return it to constructor
        return array_merge($new_columns, $columns);
    }
}


/**
 *  Thumbnail column value added by filter upon managing taxonomy in admin
 */
function tiTaxonomyColumn($columns, $column, $id)
{
    // If our new column 'thumb' is present include this HTML as output
    if ($column == 'thumb')
        $columns = '<span><img src="' . tiTaxonomyImageUrl($id, 'thumbnail', TRUE) . '" alt="' . __('Thumbnail', 'template-theme-custom-post-type') . '" class="wp-post-image" /></span>';

    // Return $columns variable back to constructor
    return $columns;
}


/**
 *  Add our custom setting menu to admin panel so user can set options for this plugin
 */
add_action('admin_menu', 'tiSettingsMenu');
function tiSettingsMenu()
{
    add_menu_page(__('Taxonomy Images settings', 'template-theme-custom-post-type'), __('Taxonomy Images', 'template-theme-custom-post-type'), 'manage_options', 'ti_settings', 'tiSettingsPage', 'dashicons-format-image', 80);
}

// This function is triggered by callback when we create new menu page for this plugin
function tiSettingsPage()
{
    // Define who can enter this page
    if (!current_user_can('manage_options')) {
        // if current user has not permission to enter this page, leave a note and let wp die
        wp_die(__('You do not have sufficient permissions to access this page.', 'template-theme-custom-post-type'));
    }

    // If wp is not dead, this HTML will be outputted to site
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


// Save our taxonomy image while edit or create term
add_action('edit_term', 'tiSaveTaxonomyImage');
add_action('create_term', 'tiSaveTaxonomyImage');

function tiSaveTaxonomyImage($term_id)
{
    // If there is some image url sent by post method, update url in database
    if (isset($_POST['tiz_taxonomy_image'])) {
        update_option('ti_taxonomy_image' . $term_id, $_POST['tiz_taxonomy_image'], false);
    }
}


// If somewhere in ulr is found edit-tags.php or term.php we will add our JavaScript to that page
if (strpos($_SERVER['SCRIPT_NAME'], 'edit-tags.php') > 0 || strpos($_SERVER['SCRIPT_NAME'], 'term.php') > 0) {
    add_action('admin_enqueue_scripts', 'tiAdminEnqueue');
}


// This function enqueue our JavaScript
function tiAdminEnqueue()
{
    // Enqueue script with this url
    wp_enqueue_script('categories-images-scripts', plugins_url('/js/ti-scripts.js', __FILE__));

    // Associative array which is sent to JavaScript as an object
    // Array can include your translations but also other data u may need to use in scipt, like hour placeholder url constant
    $ti_js_config = [
        'wordpress_ver' => get_bloginfo("version"),
        'placeholder' => CUSTOM_POST_TYPE_IMAGE_PLACEHOLDER,
    ];

    // This line sends our array into registered script. Make sure handle in this code is same as the one used when registering script
    wp_localize_script('categories-images-scripts', 'ti_config', $ti_js_config);
}
