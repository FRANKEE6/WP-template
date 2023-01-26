<?php
// This page will show single post which is of type tt_movies

// Get your header
get_header();
?>

<section class="main-content">

    <!-- Custom function which will detect page which is set for blog -->
    <?php if (is_single()) : ?>

        <!-- WordPress loops starts -->
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <!-- Set structure of each post here -->
                <h2><?php the_title() ?></h2>

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
                        <tr>
                            <td><?php the_title() ?></td>
                            <td><?php echo post_custom('tt_movie_year') ?></td>
                            <td><?php echo number_format_i18n(post_custom('tt_movie_gross')) ?></td>
                            <td><?php the_terms(get_the_ID(), 'genre', '', ' ') ?></td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr class="summary">
                            <td colspan="4"><?php the_content() ?></td>
                        </tr>
                    </tfoot>
                </table>

            <?php endwhile; ?>

            <!-- If there are no post to show -->
        <?php else : ?>
            <p><?php _e('We are sorry but this page has no post added right now.', 'template-theme') ?></p>
        <?php endif; ?>
    <?php endif; ?>

</section>

<?php
// Get your footer
get_footer();
