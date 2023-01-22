<!doctype html>

<!-- Let WordPress insert language attributes from database -->
<html <?php language_attributes(); ?>>

<head>
    <!-- Let WordPress insert charset info from database -->
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- WordPress will print all styles and scripts here -->
    <?php wp_head(); ?>
</head>

<!-- WordPress will autogenerate body classes -->

<body <?php body_class(); ?>>

    <!-- This allows developers to hook actions on body open event -->
    <?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'template_theme'); ?></a>

    <?php
    // This code will generate some classes depending on some customizer options u have set
    $wrapper_classes  = 'site-header';
    $wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
    $wrapper_classes .= (true === get_theme_mod('display_title_and_tagline', true)) ? ' has-title-and-tagline' : '';
    ?>

    <!-- Here your classes from above will be included -->
    <header id="masthead" class="<?php echo esc_attr($wrapper_classes); ?>">
        <section class="mainHeader">
            <?php
            // On this place your custom logo will be placed if u have one
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if (has_custom_logo()) {
                echo '<a class="site-logo" href="' . get_home_url() . '"> <img src="' .
                    esc_url($logo[0]) . '" alt="' . get_bloginfo('name') .
                    '"width="200" height="200"></a>';
            }
            ?>

            <!-- With get_bloginfo u can echo various informations -->
            <div class="header-wrapper">
                <h1><?php
                    $site_name = get_bloginfo('name');
                    $site_name .= ' ';
                    $site_name .= get_bloginfo('description');
                    echo $site_name;
                    ?></h1>
                <ul class="openingHours">

                    <!-- This way u can insert data from customizer -->
                    <li><?php echo get_theme_mod('open_hours_1') ?></li>
                    <li><?php echo get_theme_mod('open_hours_2') ?></li>
                </ul>
            </div>

            <?php
            // This is how you define location of your menu
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'main-menu-big',
                'container' => 'nav',
                'menu_id' => 'mainNav'
            )); ?>

            <?php
            // This is how you define location of your widget
            if (is_active_sidebar('sidebar-1')) : ?>
                <div class="widget-area" role="complementary">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </div>
            <?php endif; ?>
        </section>
    </header><!-- #masthead -->

    <!-- Here i am using my own function which generate class from page slug so i can hook some extra css here -->
    <main id="main" class="site-main <?php template_theme_add_page_slug()  ?>">