<?php
/**
 * Plugin Name: WP Store Selector
 * Description: Adds a store selection dropdown to WordPress registration form and allows admin to manage store options.
 * Version: 1.0.0
 * Author: Anand Aage
 * Author URI: https://mail.google.com/mail/?view=cm&fs=1&to=anand.aage.work@gmail.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-store-selector
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WP_STORE_SELECTOR_VERSION', '1.0.0');
define('WP_STORE_SELECTOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_STORE_SELECTOR_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once WP_STORE_SELECTOR_PLUGIN_DIR . 'includes/class-wp-store-selector.php';

/**
 * Initialize the plugin
 */
function wp_store_selector_init() {
    $plugin = new WP_Store_Selector();
    $plugin->init();
}
add_action('plugins_loaded', 'wp_store_selector_init');

/**
 * Plugin activation hook
 * Sets up default store options
 */
function wp_store_selector_activate() {
    // Add default store options
    $default_stores = array(
        'Store 1',
        'Store 2',
        'Store 3',
        'Store 4',
        'Store 5',
        'Store 6',
        'Store 7',
        'Store 8',
        'Store 9',
        'Store 10'
    );
    update_option('wp_store_selector_options', $default_stores);
}
register_activation_hook(__FILE__, 'wp_store_selector_activate');

/**
 * Plugin deactivation hook
 * Cleanup if needed
 */
function wp_store_selector_deactivate() {
    // Cleanup if needed
}
register_deactivation_hook(__FILE__, 'wp_store_selector_deactivate'); 