<?php
// This page will show single post which is of type tt_movies

// Get your header
get_header();
?>

<section class="main-content">
    <h2><?php _e('Here is table of my favourite films', 'template-theme') ?></h2>

    <!-- Custom query created bcs on main blog page which is home we have standard posts. On other pages, we need new query as the main loop is retrieving post type page which we need to keep that way -->
    <?php
    // Makes sure pagination works with custom query
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'posts_per_page'    => get_option('posts_per_page'),
        'post_type'         => 'tt_movies',
        'post_status'       => 'publish',
        'orderby'           => 'post_title',
        'order'             => 'ASC',
        'paged'             => $paged,
    );

    $films_custom_query = new WP_Query($args);
    ?>

    <!-- WordPress loops starts -->
    <?php if ($films_custom_query->have_posts()) : ?>
        <table>
            <thead>
                <tr>
                    <th><?php echo _x('Title', 'Title of movie in table', 'template-theme') ?></th>
                    <th><?php echo _x('Year', 'Release year of movie in table', 'template-theme') ?></th>
                    <th><?php echo _x('Gross', 'Worldwide gross of movie in table', 'template-theme') ?></th>
                </tr>
            </thead>

            <tbody>
                <!-- Set structure of each post here -->
                <?php while ($films_custom_query->have_posts()) : $films_custom_query->the_post(); ?>

                    <tr>
                        <td>
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        </td>
                        <td>
                            <?php echo post_custom('tt_movie_year') ?>
                        </td>
                        <td>
                            <?php echo number_format_i18n(post_custom('tt_movie_gross')) ?>
                        </td>
                    </tr>

                <?php endwhile; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3"><?php if (function_exists('template_theme_total_gross')) {
                                        echo number_format_i18n(template_theme_total_gross(), 0);
                                    } ?></td>
                </tr>
            </tfoot>
        </table>

        <?php
        // Makes sure pagination works with custom query
        $GLOBALS['wp_query']->max_num_pages = $films_custom_query->max_num_pages;

        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => __('Back', 'template-theme'),
            'next_text' => __('Next', 'template-theme'),
        )); ?>

        <!-- If there are no post to show -->
    <?php else : ?>
        <p><?php _e('We are sorry but no movies were found :(', 'template-theme') ?></p>
        <?php wp_reset_postdata() ?>
    <?php endif; ?>

</section>

<?php
// Get your footer
get_footer();
