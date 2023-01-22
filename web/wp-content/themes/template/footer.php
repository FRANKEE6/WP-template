</main><!-- #main -->

<footer id="colophon" class="site-footer">
    <div class="footer-flex">
        <section class="address">
            <ul>
                <!-- Here i am retrieving several informations automaticly from WordPress options database and from customizer settings -->
                <li><?php echo get_bloginfo('name') ?></li>
                <li><?php echo get_theme_mod('address_street') ?></li>
                <li><?php echo get_theme_mod('address_city') ?></li>

                <!-- Using my own function to retrieve right format of tel number to use it in achor with tel: -->
                <li><a href="tel:<?php echo template_theme_filter_telephone_number(get_theme_mod('contact_tel')) ?>">
                        <?php echo get_theme_mod('contact_tel') ?></a></li>
                <li><a href="mailto:<?php echo get_theme_mod('contact_mail') ?>">
                        <?php echo get_theme_mod('contact_mail') ?></a></li>
            </ul>
        </section>
        <section class="google-map">
            <?php
            // Implementation of third sidebar
            if (is_active_sidebar('sidebar-3')) : ?>
                <div class="widget-area" role="complementary">
                    <?php dynamic_sidebar('sidebar-3'); ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
    <section class="copyright">
        <p>
            <!-- This section contain text retrieved from customizer settings -->
            <?php echo get_theme_mod('copy_by') ?>
            <span>
                <?php echo get_theme_mod('copy_text') ?>
            </span>
        </p>
    </section>
</footer><!-- #colophon -->

<?php
// This allows WordPress to insert scripts into footer
wp_footer(); ?>

</body>

</html>