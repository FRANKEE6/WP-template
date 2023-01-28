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

                <?php
                $country_data = wp_get_post_terms($post->ID, 'country');
                $country_data = $country_data[0];
                $date = date_create(post_custom('tt_director_date'));
                ?>

                <table>
                    <thead>
                        <tr>
                            <th><?php echo _x('Nationality', 'Director nationality column', 'template-theme') ?></th>
                            <th><?php echo _x('Flag', 'Heading for flag images column', 'template-theme') ?></th>
                            <th><?php echo _x('Birthdate', 'Birthdates of directors column', 'template-theme') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><?php the_terms(get_the_ID(), 'country') ?></td>
                            <td><img src="<?= get_option('ti_taxonomy_image' . $country_data->term_taxonomy_id) ?>" alt="<?= $country_data->name ?> flag"></td>
                            <td><?php echo date_format($date, get_option('date_format')) ?>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td>

                            </td>
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
