<?php

/**
 *  This function retrieves value of selected seo_meta field
 * 
 *  If value can't be retrieved, empty string is returned
 * 
 * @param $field
 * @param bool $post_ID
 * @return string
 */

function template_theme_get_SEO_meta($field, $post_ID = false)
{
    if (!$post_ID) {
        $post_ID = get_post_field('ID', get_post());
    }

    $field = 'seo_meta_' . $field;
    $value = get_post_meta($post_ID, $field, true);

    return $value ? (string) $value : '';
}


/**
 *  Place our meta tag in head tag of page if page is singular
 */
add_action('wp_head', 'template_theme_add_SEO_meta_tags');
function template_theme_add_SEO_meta_tags()
{
    if (is_singular()) {
        $post_ID = get_the_ID();

        $SEO_description    = esc_attr(template_theme_get_SEO_meta('meta-description'));
        $fb_title           = esc_attr(template_theme_get_SEO_meta('facebook-title'));
        $fb_description     = esc_attr(template_theme_get_SEO_meta('facebook-description'));
        $fb_image           = esc_url(template_theme_get_SEO_meta('facebook-image'));
        $url                = esc_url(get_permalink($post_ID));

        // If there are no values in our meta box, we will try to retrieve alternative values from database
        if ('' === $SEO_description) {
            $SEO_description = wp_trim_words(apply_filters('the_excerpt', get_the_content()), 15);
        }
        if ('' === $fb_title) {
            $fb_title = esc_attr(get_the_title());
        }
        if ('' === $fb_description) {
            $fb_description = $SEO_description;
        }
        if ('' === $fb_image) {
            $fb_image = get_the_post_thumbnail_url($post_ID);
        }

        if ($SEO_description) :
?>
            <meta name="description" content="<?= $SEO_description ?>">
        <?php endif;
        if ($fb_title && $fb_description) : ?>
            <meta property="og:locale" content="<?= get_locale() ?>">
            <meta property="og:type" content="article">
            <meta property="og:title" content="<?= $fb_title ?>">
            <meta property="og:description" content="<?= $fb_description ?>">
            <meta property="og:url" content="<?= $url ?>">
            <meta property="og:site_name" content="<?= esc_attr(get_bloginfo('name')) ?>">
            <?php if ($fb_image) : ?>
                <meta property="og:image" content="<?= $fb_image ?>">
<?php endif;
        endif;
    }
}
