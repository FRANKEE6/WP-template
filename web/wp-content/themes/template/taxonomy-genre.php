<?php
// This page will show single post which is of type tt_movies

// Get your header
get_header();
?>

<h1><?php single_tag_title() ?></h1>

<section class="main-content">

    <!-- WordPress loops starts -->
    <?php if (have_posts()) : ?>
        <table>
            <thead>
                <tr>
                    <th><?php echo _x('Title', 'Title of movie in table', 'template-theme') ?></th>
                    <th><?php echo _x('Year', 'Release year of movie in table', 'template-theme') ?></th>
                    <th><?php echo _x('Gross', 'Worldwide gross of movie in table', 'template-theme') ?></th>
                    <th><?php echo _x('Genre', 'Movie genre in table', 'template-theme') ?></th>
                </tr>
            </thead>

            <tbody>
                <?php while (have_posts()) : the_post(); ?>

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
                        <td>
                            <?php the_terms(get_the_ID(), 'genre', '', ' ') ?>
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
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => __('Back', 'template-theme'),
            'next_text' => __('Next', 'template-theme'),
        )); ?>

        <!-- If there are no post to show -->
    <?php else : ?>
        <p><?php _e('We are sorry but no movies were found :(', 'template-theme') ?></p>
    <?php endif; ?>

</section>

<?php
// Get your footer
get_footer();
