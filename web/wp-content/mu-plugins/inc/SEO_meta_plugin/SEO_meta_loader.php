<?php
// First showcase of constants which u can use at any plugin u are creating, not only mu plugin
define('TEMPLATE_THEME_SEO_META_PLUGIN', __FILE__);
define('TEMPLATE_THEME_SEO_META_PLUGIN_DIR', untrailingslashit(dirname(TEMPLATE_THEME_SEO_META_PLUGIN)));


/**
 *  Load core functionality of plugin
 */

require_once TEMPLATE_THEME_SEO_META_PLUGIN_DIR . '/core/SEO_meta_core.php';


/**
 *  Load functionality for admin dashboard
 */
if (is_admin()) {
    require_once TEMPLATE_THEME_SEO_META_PLUGIN_DIR . '/admin/SEO_meta_admin.php';
}
