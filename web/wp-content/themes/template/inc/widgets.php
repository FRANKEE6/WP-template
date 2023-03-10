<?php

/**
 *  Register Widget area.
 * 
 *  Here u can register and set atributes of your widgets
 * 
 *  https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * 
 */
function template_theme_widgets_init()
{

    register_sidebar(
        array(
            'name' => esc_html__('Header', 'template-theme'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Here u can insert content which will show up in your header', 'template-theme'),
            'before_widget' => '<section class="widget %2$s">',
            'after_widget' => '</section>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Side content', 'template-theme'),
            'id' => 'sidebar-2',
            'description' => esc_html__('Here u can insert content which will show up on side of your page', 'template-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => esc_html__('Footer', 'template-theme'),
            'id' => 'sidebar-3',
            'description' => esc_html__('Here u can insert content which will show up in your footer', 'template-theme'),
            'before_widget' => '<div id="footer-sidebar" class="footer-sidebar-widget">',
            'after_widget' => '</div>',
        )
    );
}
add_action('widgets_init', 'template_theme_widgets_init');
