<?php
// This will include your header.php file
get_header();

// Here is condition which will show my sidebar only if active and if current page is front page.
if (is_front_page() && is_active_sidebar('sidebar-2')) : ?>

    <div class="frontpage-flex-wrapper">
        <section class="main-content">

            <!-- the_content will insert data of your page from database -->
            <?php the_content(); ?>
        </section>
        <aside class="side-content">
            <div class="widget-area" role="complementary">

                <!-- Defined placement of another sidebar -->
                <?php dynamic_sidebar('sidebar-2'); ?>
            </div>

        </aside>
    </div>
<?php
// If sidebar is inactive or we are not on front page, this code will be executed.
else : ?>
    <section class="main-content">

        <!-- the_content will insert data of your page from database -->
        <?php the_content(); ?>
    </section>
<?php endif; ?>


<?php
// This will include your footer.php file
get_footer();
