<?php
// Like this u can change ordering of your posts by some value
// https://developer.wordpress.org/reference/functions/get_posts/

$posts = get_posts(array(
    'posts_per_page'    => get_option('posts_per_page'),
    'meta_key'          => '_post_view_count',
    'orderby'           => 'meta_value_num',
    'order'             => 'DESC',
));
