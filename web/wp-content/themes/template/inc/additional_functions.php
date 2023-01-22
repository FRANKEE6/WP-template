<?php

/**
 *  Functions
 * 
 *  Here u can write your own functions if u need
 */

// Transform phone number to desired format.
function template_theme_filter_telephone_number($number)
{
    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    $number = str_replace(array('+', '-'), '', $number);
    if ($number[0] == '0') {
        $number = ltrim($number, $number[0]);
    }
    $number = '+421' . $number;

    return $number;
}


// Get and echo the slug of page
function template_theme_add_page_slug()
{
    global $post;
    if (isset($post)) {
        $page_slug = $post->post_name;
    }
    echo esc_attr($page_slug);
}

// Function that will detect a page which is set to display posts
function is_blog()
{
    if (is_front_page() && is_home()) {
        return false;
    } elseif (is_front_page()) {
        return false;
    } elseif (is_home()) {
        return get_option('page_for_posts'); // Returns blog page ID
    } else {
        return false;
    }
}


// My function which will sanitize text in my customizer expansion
function template_theme_sanitize_copy_text($content)
{
    return wp_kses($content, array(
        'strong' => array(),
        'em' => array(),
        'small' => array(),
        'p' => array(),
        'a' => array(
            'href' => array(),
            'title' => array(),
        )
    ));
}


// My function which will sanitize email address in my customizer expansion
function template_theme_sanitize_email($email, $setting)
{
    return (is_email($email) ? $email : $setting->default);
}


// My function which will sanitize checkbox in my customizer expansion
// This is just example. Expansion which it is used for do not exist in this template
/*
function template_theme_sanitize_checkbox($checked)
{
    // Boolean check.
    return ((isset($checked) && true == $checked) ? true : false);
}
*/