<?php
// This page have example of WordPress loop
// It will work if u have set some page as your blog page in WordPress settings

// Get your header
get_header();
?>

<section class="main-content">

    <!-- Custom function which will detect page which is set for blog -->
    <?php if (is_blog()) : ?>
        <h1>Blog</h1>

        <!-- WordPress loops starts -->
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>

                <!-- Set structure of each post here -->
                <article <?php post_class() ?>>
                    <h2><?php the_title() ?></h2>
                    <section class="post-data">
                        <time datetime="<?php echo get_the_date('Y-m-d') ?>">
                            <?php echo get_the_date() ?>
                        </time>
                        <p><em>
                                <?php the_author() ?>
                            </em></p>
                    </section>
                    <!-- the_content will insert data of your post from database -->
                    <?php the_content(); ?>

                </article>
            <?php endwhile; ?>

            <!-- If there are no post to show -->
        <?php else : ?>
            <p>We are sorry but this page has no post added right now.</p>
        <?php endif; ?>
    <?php endif; ?>

</section>

<?php
// Get your footer
get_footer();