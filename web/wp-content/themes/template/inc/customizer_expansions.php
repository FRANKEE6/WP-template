<?php

/**
 *  Customizer
 * 
 *  Here u set up your own sections into customizer
 * 
 *  If u gonna add a lot, consider grouping sections-setting-controls for each section separately
 * 
 *  https://codex.wordpress.org/Theme_Customization_API
 * 
 *  https://developer.wordpress.org/reference/hooks/customize_register/
 * 
 */

add_action('customize_register', 'templete_theme_customize_register');
function templete_theme_customize_register($wp_customize)
{
    // Sections
    // https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
    $wp_customize->add_section('contact_informations', array(
        'title' => __('Kontaktné informácie', 'template_theme'),
        'priority' => 30,
        'description' => __('Úprava otváracích hodín v hlavičke', 'template_theme'),
    ));

    $wp_customize->add_section('open_hours', array(
        'title' => __('Open hours', 'template_theme'),
        'priority' => 31,
        'description' => __('Adjust your opening hours in header', 'template_theme'),
    ));

    $wp_customize->add_section('address', array(
        'title' => __('Address of company', 'template_theme'),
        'priority' => 32,
        'description' => __('Here u can write address of your company', 'template_theme'),
    ));

    $wp_customize->add_section('copyright', array(
        'title' =>  __('Copyright', 'template_theme'),
        'priority' => 33,
        'description' =>  __('Adjust text in your copyright section in footer', 'template_theme'),
    ));


    // Settings
    // https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
    $wp_customize->add_setting('contact_tel', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_setting('contact_mail', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'template_theme_sanitize_email',
    ));

    $wp_customize->add_setting('open_hours_1', array(
        'default' => __('Wednesday - Sunday: 12:00 - 20:00', 'template_theme'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_setting('open_hours_2', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_setting('address_street', array(
        'default' => __('Street and street number', 'template_theme'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_setting('address_city', array(
        'default' => __('City and postal code', 'template_theme'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_setting('copy_by', array(
        'default' => '&copy; ' . date("Y"),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_setting('copy_text', array(
        'default' => get_option('blogname'),
        'transport' => 'refresh',
        'sanitize_callback' => 'template_theme_sanitize_copy_text',
    ));

    // Controls
    // https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
    $wp_customize->add_control('contact_tel', array(
        'type' => 'tel',
        'priority' => 10,
        'section' => 'contact_informations',
        'label' => __('Telephone number', 'template_theme'),
        'description' => __('Insert telephone number to your company', 'template_theme'),
    ));

    $wp_customize->add_control('contact_mail', array(
        'type' => 'mail',
        'priority' => 11,
        'section' => 'contact_informations',
        'label' => __('Mail address', 'template_theme'),
        'description' => __('Insert mail address of your company', 'template_theme'),
    ));

    $wp_customize->add_control('open_hours_1', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'open_hours',
        'label' => __('Open hours - first line', 'template_theme'),
        'description' => __('Place reserved for your open hours', 'template_theme'),
    ));

    $wp_customize->add_control('open_hours_2', array(
        'type' => 'text',
        'priority' => 11,
        'section' => 'open_hours',
        'label' => __('Open hours - second line', 'template_theme'),
        'description' => __('Place reserved for your open hours, leave blank if you do not want this line to show', 'template_theme'),
    ));

    $wp_customize->add_control('address_street', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'address',
        'label' => __('Street', 'template_theme'),
        'description' => __('Inset name of the street and number of building', 'template_theme'),
    ));

    $wp_customize->add_control('address_city', array(
        'type' => 'text',
        'priority' => 11,
        'section' => 'address',
        'label' => __('City', 'template_theme'),
        'description' => __('Insert name of the city and postal code', 'template_theme'),
    ));

    $wp_customize->add_control('copy_by', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'copyright',
        'label' => __('Copyright', 'template_theme'),
        'description' => __('Place reserved for copyright symbol and year', 'template_theme'),
    ));

    $wp_customize->add_control('copy_text', array(
        'type' => 'textarea',
        'priority' => 20,
        'section' => 'copyright',
        'label' => __('Additional text', 'template_theme'),
        'description' => __('Place reserved for some additional text', 'template_theme'),
    ));
}
