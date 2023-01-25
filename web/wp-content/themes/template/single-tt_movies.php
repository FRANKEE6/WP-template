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
                <h1><?php the_title() ?></h1>
                <?php the_content() ?>

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
