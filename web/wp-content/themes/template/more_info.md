# Here u can find more helpful informations

## 1. What u need to run template

- Absolute minimum is Index.php and style.css
- I do recommend to add header.php and footer.php as well
- If u need more templates than just simple index.php, u should chceck [this link](https://developer.wordpress.org/themes/basics/template-hierarchy/) to find suitable one

## 2. How to activate custom fields in your admin dashboard prior to WP version 6.1.1

- Get into your post/pages section
- Open some post/page
- Click on right top more options button
- Switch to panels section
- In additional field activate Custom fields

## 3. Wordpress speed up rules

- Get rid of code u do not need (less code = faster execution of existing one)
- Deactivate and uninstall plugins u do not need (even deactivated plugins can drag site performance)
- Use caching plugins (in this template it's autoptimize and wp-catche)
- In .htaccess u can find some if statements with settings for server if server do support them. They should speed up your site as well

## 4. Where to put code

- First u have to determine functionality of your code:

1. If it strictly apply to your theme (styles, templates, etc.), put it in some inc files of functions.php
2. If code should stay in use after switching a theme (some shortcodes , custom meta fields, custom post types and so), put it in must-use plugin

- In general decision is up to you. All php code can be in must-use plugin or in functions.php. U can also mix those. It's about your preference and about what you find more transparent and flexible
