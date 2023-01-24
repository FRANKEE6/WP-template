<?php
// First showcase of constants which u can use at any plugin u are creating, not only mu plugin
define('TEMPLATE_THEME_MOST_VIEWED_PLUGIN', __FILE__);
define('TEMPLATE_THEME_MOST_VIEWED_PLUGIN_DIR', untrailingslashit(dirname(TEMPLATE_THEME_MOST_VIEWED_PLUGIN)));
define('TEMPLATE_THEME_MOST_VIEWED_PLUGIN_URL', untrailingslashit(plugin_dir_url(TEMPLATE_THEME_MOST_VIEWED_PLUGIN)));


/**
 *  Load core functionality of plugin
 */

require_once TEMPLATE_THEME_MOST_VIEWED_PLUGIN_DIR . '/core/most_viewed_core.php';


/**
 *  Load our custom widget
 */

require_once TEMPLATE_THEME_MOST_VIEWED_PLUGIN_DIR . '/widget/most_viewed_widget.php';


/**
 *  Load functionality for admin dashboard
 */
if (is_admin()) {
    require_once TEMPLATE_THEME_MOST_VIEWED_PLUGIN_DIR . '/admin/most_viewed_admin.php';
}
