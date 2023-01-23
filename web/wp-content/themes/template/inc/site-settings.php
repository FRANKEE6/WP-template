<?php

/**
 *  Sets up theme defaults and registers support for various WordPress features.
 * 
 */

function template_theme_setup()
{
    /**
     *  Make theme available for translation.
     * 
     * Translations can be filed in the /languages/ directory.
     * 
     *  https://developer.wordpress.org/reference/functions/load_theme_textdomain/
     * 
     */

    load_theme_textdomain('template_theme', TEMPLATE_DIRECTORY . '/languages');


    /**
     *  Theme support section
     * 
     *  https://codex.wordpress.org/Theme_Features
     * 
     *  https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/
     * 
     *  https://developer.wordpress.org/reference/functions/add_theme_support/
     */

    // Let WordPress manage the document title.
    // https://codex.wordpress.org/Title_Tag
    // https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
    add_theme_support('title-tag');


    // Define formats that will be availible to use for users
    // https://wordpress.org/documentation/article/post-formats/
    add_theme_support(
        'post-formats',
        array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
        )
    );


    // Enable support for Post Thumbnails on posts and pages.
    // https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    add_theme_support('post-thumbnails');


    // Registers navigation menu locations for a theme
    // https://developer.wordpress.org/reference/functions/register_nav_menus/
    register_nav_menus(
        array(
            'primary' => esc_html__('Main menu', 'template_theme'),
            'secondary'  => esc_html__('Secondary menu', 'template_theme'),
        )
    );


    // This feature allows the use of HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption.
    // https://developer.wordpress.org/reference/functions/add_theme_support/#html5
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'meta',
            'navigation-widgets',
        )
    );


    // Add support for core custom logo.
    // Height & width parameters are only suggestions for user about which dimensions should image have
    // https://codex.wordpress.org/Theme_Logo
    // https://developer.wordpress.org/reference/functions/add_theme_support/#custom-logo
    add_theme_support(
        'custom-logo',
        array(
            'height'               => 181,
            'width'                => 250,
            'flex-width'           => true,
            'flex-height'          => true,
            'header-text' => array('site-title', 'site-description'),
        )
    );

    // This feature enables Selective Refresh for Widgets being managed within the Customizer.
    // https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
    add_theme_support('customize-selective-refresh-widgets');

    // This will enable the support for default Gutenberg block styles in the theme.
    add_theme_support('wp-block-styles');

    // Enabling theme support for align full and align wide option for the block editor.
    add_theme_support('align-wide');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for custom line height controls.
    add_theme_support('custom-line-height');

    // Add support for experimental link color control.
    add_theme_support('experimental-link-color');

    // Add support for experimental cover block spacing.
    add_theme_support('custom-spacing');

    // Add support for custom units.
    // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
    add_theme_support('custom-units');

    // This feature enables Custom_Backgrounds support for a theme.
    // https://developer.wordpress.org/reference/functions/add_theme_support/#custom-background
    add_theme_support('custom-background', array(
        'default-image'          => '',
        'default-preset'         => 'default', // 'default', 'fill', 'fit', 'repeat', 'custom'
        'default-position-x'     => 'left',    // 'left', 'center', 'right'
        'default-position-y'     => 'top',     // 'top', 'center', 'bottom'
        'default-size'           => 'auto',    // 'auto', 'contain', 'cover'
        'default-repeat'         => 'repeat',  // 'repeat-x', 'repeat-y', 'repeat', 'no-repeat'
        'default-attachment'     => 'scroll',  // 'scroll', 'fixed'
        'default-color'          => '',
        'wp-head-callback'       => '_custom_background_cb',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
    ));

    // This feature enables Custom_Headers support for a theme.
    // https://developer.wordpress.org/reference/functions/add_theme_support/#custom-header
    add_theme_support('custom-header', array(
        'default-image'          => '',
        'random-default'         => false,
        'width'                  => 0,
        'height'                 => 0,
        'flex-height'            => false,
        'flex-width'             => false,
        'default-text-color'     => '',
        'header-text'            => true,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
        'video'                  => false,
        'video-active-callback'  => 'is_front_page',
    ));

    // This feature enables Automatic Feed Links for post and comment in the head.
    // https://developer.wordpress.org/reference/functions/add_theme_support/#feed-links
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'template_theme_setup');


/**
 *  Add support for uploading SVG files
 * 
 *  https://developer.wordpress.org/reference/hooks/upload_mimes/
 * 
 */
add_filter('upload_mimes', 'template_theme_add_file_types_to_uploads');

function template_theme_add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}


/**
 *  This code links your css into login page of WordPress
 *  In this css file plase styles specific for this page
 * 
 *  Second part will insert our style which will substitue WP logo with site logo from customizer
 * 
 *  https://developer.wordpress.org/reference/hooks/login_head/
 */
add_action('login_head', 'template_theme_custom_login');
function template_theme_custom_login()
{
    echo '<link rel="stylesheet" href="' . THEME_DIRECTORY_URI . '/css/custom_login.css">';

    // Second part starts here
    if (has_custom_logo()) :
        $logo = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'thumbnail');
?>

        <style>
            .login h1 a {
                background-image: url("<?php echo esc_url($logo) ?>");
            }
        </style>

<?php endif;
}


/**
 *  Trough this filter u can substitue url address of logo at login form with your custom url
 *  In this case it's url to homepage of our site
 * 
 *  https://developer.wordpress.org/reference/hooks/login_headerurl/
 * 
 */
add_filter('login_headerurl', 'template_theme_login_header_url');
function template_theme_login_header_url()
{
    return get_home_url();
}


/**
 *  Admin dashboard items reorder
 * 
 *  Here u can list items in your desired order
 * 
 *  https://developer.wordpress.org/?s=custom_menu_order
 */
add_filter('custom_menu_order', 'template_theme_menu_order', 999);
add_filter('menu_order', 'template_theme_menu_order', 999);

function template_theme_menu_order($__return_true)
{
    return array(
        'index.php', // Dashboard
        'separator1', // Medzera
        'edit.php', // Posts
        'edit.php?post_type=page', // Pages
        'upload.php', // Media
        'edit-comments.php', // Comments
        'separator2', // Medzera
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'complianz', // Complianz (cookie plugin)
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
    );
}
