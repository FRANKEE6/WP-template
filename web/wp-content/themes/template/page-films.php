<?php
// This page will show single post which is of type tt_movies

// Get your header
get_header();
?>

<section class="main-content">
    <h2><?php _e('Here is table of my favourite films', 'template-theme') ?></h2>

    <!-- Custom query created bcs on main blog page which is home we have standard posts. On other pages, we need new query as the main loop is retrieving post type page which we need to keep that way -->
    <?php
    $args = array(
        'posts_per_page'    => '10',
        'post_type'         => 'tt_movies',
        'post_status'       => 'publish',
    );

    $films_custom_query = new WP_Query($args);
    ?>

    <!-- WordPress loops starts -->
    <?php if ($films_custom_query->have_posts()) : ?>
        <?php while ($films_custom_query->have_posts()) : $films_custom_query->the_post(); ?>
            <!-- Set structure of each post here -->
            <h3><?php the_title() ?></h3>

        <?php endwhile; ?>

        <!-- If there are no post to show -->
    <?php else : ?>
        <p><?php _e('We are sorry but no movies were found :(', 'template-theme') ?></p>
        <?php wp_reset_postdata() ?>
    <?php endif; ?>

</section>

<?php
// Get your footer
get_footer();
