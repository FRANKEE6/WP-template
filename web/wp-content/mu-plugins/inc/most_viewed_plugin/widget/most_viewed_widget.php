<?php

/**
 *  Add our custom widget
 * 
 *  Widgets must be object oriented
 */

add_action('widgets_init', 'template_theme_most_viewed_widget_init');
function template_theme_most_viewed_widget_init()
{
    register_widget('template_theme_most_viewed_widget');
}
class Template_Theme_Most_Viewed_Widget extends WP_Widget
{
    // widget constructor
    public function __construct()
    {
        $widget_details = array(
            'classname'   => 'template_theme_most_viewed_widget',
            'description' => __('List of most viewed posts', 'template-theme-MU-plugin')
        );
        parent::__construct('template_theme_most_viewed_widget', __('Most viewed posts', 'template-theme-MU-plugin'), $widget_details);
    }


    // outputs the content of the widget
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_tittle', $instance['title']);
        $number = $instance['number'];
        $excerpt_option = isset($instance['check_box']) ? true : false;

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $posts = get_posts(array(
            'posts_per_page' => $number,
            'meta_key'      => '_post_view_count',
            'orderby'       => 'meta_value_num',
            'order'         => 'DESC',
        ));

        if ($posts) {

            echo '<ul>';

            foreach ($posts as $post) {

                $template = '<li>';
                $template .= '<a href="';
                $template .= esc_url(get_permalink($post->ID));
                $template .= '">';
                $template .= apply_filters('the_title', $post->post_title);
                $template .= '</a>';

                if ($excerpt_option) {
                    $template .= '<small> ';
                    $template .= wp_trim_words(apply_filters('the_excerpt', $post->post_content), 5);
                    $template .= '</small>';
                }

                $template .= '</li>';

                echo $template;
            }

            echo '</ul>';
        }

        echo $args['after_widget'];
    }


    // creates the back-end form
    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $number = isset($instance['number']) ? $instance['number'] : 3;
        $checkbox = isset($instance['check_box']) ? $instance['check_box'] : NULL;
?>
        <p>
            <label for="<?php echo $this->get_field_name('title') ?>">
                <?php _e('Title', 'template-theme-MU-plugin'); ?> :
            </label>
            <input type="text" class="widefat" value="<?php echo esc_attr($title) ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_name('number') ?>">
                <?php _e('Number of posts to show', 'template-theme-MU-plugin') ?> :
            </label>
            <input type="number" class="tiny-text" step="1" min="1" size="3" value="<?php echo esc_attr($number); ?>" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number') ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_name('check_box') ?>">
                <?php _e('Show excerpt', 'template-theme-MU-plugin') ?> :
            </label>
            <input type="checkbox" class="checkbox" <?php checked($checkbox, 'on'); ?> id="<?php echo $this->get_field_id('check_box'); ?>" name="<?php echo $this->get_field_name('check_box') ?>">
        </p>
<?php
    }


    // updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $new_instance['title'] = strip_tags($new_instance['title']);
        $new_instance['number'] = intval($new_instance['number']);

        return $new_instance;
    }
}
