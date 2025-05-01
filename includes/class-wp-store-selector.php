<?php
/**
 * Main plugin class
 */
class WP_Store_Selector {
    /**
     * Initialize the plugin
     */
    public function init() {
        // Add store field to registration form
        add_action('register_form', array($this, 'add_store_field'));
        
        // Validate store field
        add_action('registration_errors', array($this, 'validate_store_field'), 10, 3);
        
        // Save store field
        add_action('user_register', array($this, 'save_store_field'));
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        // Add store field to user profile
        add_action('show_user_profile', array($this, 'add_store_field_to_profile'));
        add_action('edit_user_profile', array($this, 'add_store_field_to_profile'));
        
        // Save store field from user profile
        add_action('personal_options_update', array($this, 'save_store_field_from_profile'));
        add_action('edit_user_profile_update', array($this, 'save_store_field_from_profile'));
    }

    /**
     * Add store field to registration form
     */
    public function add_store_field() {
        $stores = get_option('wp_store_selector_options', array());
        ?>
        <p>
            <label for="user_store"><?php _e('Store', 'wp-store-selector'); ?><br />
            <select name="user_store" id="user_store" class="input">
                <option value=""><?php _e('Select a store', 'wp-store-selector'); ?></option>
                <?php foreach ($stores as $store) : ?>
                    <option value="<?php echo esc_attr($store); ?>"><?php echo esc_html($store); ?></option>
                <?php endforeach; ?>
            </select>
            </label>
        </p>
        <?php
    }

    /**
     * Validate store field
     */
    public function validate_store_field($errors, $sanitized_user_login, $user_email) {
        if (empty($_POST['user_store'])) {
            $errors->add('store_error', __('Please select a store.', 'wp-store-selector'));
        }
        return $errors;
    }

    /**
     * Save store field
     */
    public function save_store_field($user_id) {
        if (!empty($_POST['user_store'])) {
            update_user_meta($user_id, 'user_store', sanitize_text_field($_POST['user_store']));
        }
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Store Selector Settings', 'wp-store-selector'),
            __('Store Selector', 'wp-store-selector'),
            'manage_options',
            'wp-store-selector',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('wp_store_selector_options', 'wp_store_selector_options', array(
            'type' => 'array',
            'sanitize_callback' => array($this, 'sanitize_store_options')
        ));
    }

    /**
     * Sanitize store options
     */
    public function sanitize_store_options($input) {
        if (is_string($input)) {
            $input = explode("\n", $input);
        }
        if (!is_array($input)) {
            $input = array();
        }
        return array_map('sanitize_text_field', $input);
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('wp_store_selector_options');
                $stores = get_option('wp_store_selector_options', array());
                if (!is_array($stores)) {
                    $stores = array();
                }
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="store_options"><?php _e('Store Options', 'wp-store-selector'); ?></label>
                        </th>
                        <td>
                            <textarea name="wp_store_selector_options" id="store_options" rows="10" cols="50" class="large-text"><?php echo esc_textarea(implode("\n", $stores)); ?></textarea>
                            <p class="description"><?php _e('Enter one store name per line', 'wp-store-selector'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        global $pagenow;
        
        // Load on registration page, login page, or when not logged in
        if (is_page('register') || 
            $pagenow === 'wp-login.php' || 
            (!is_user_logged_in() && (is_page() || is_singular()))) {
            wp_enqueue_style(
                'wp-store-selector',
                WP_STORE_SELECTOR_PLUGIN_URL . 'assets/css/custom.css',
                array(),
                WP_STORE_SELECTOR_VERSION
            );
            wp_enqueue_script(
                'wp-store-selector',
                WP_STORE_SELECTOR_PLUGIN_URL . 'assets/js/custom.js',
                array('jquery'),
                WP_STORE_SELECTOR_VERSION,
                true
            );
        }
    }

    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ('settings_page_wp-store-selector' !== $hook) {
            return;
        }
        wp_enqueue_style(
            'wp-store-selector-admin',
            WP_STORE_SELECTOR_PLUGIN_URL . 'assets/css/custom.css',
            array(),
            WP_STORE_SELECTOR_VERSION
        );
        wp_enqueue_script(
            'wp-store-selector-admin',
            WP_STORE_SELECTOR_PLUGIN_URL . 'assets/js/custom.js',
            array('jquery'),
            WP_STORE_SELECTOR_VERSION,
            true
        );
    }

    /**
     * Add store field to user profile
     */
    public function add_store_field_to_profile($user) {
        $stores = get_option('wp_store_selector_options', array());
        $selected_store = get_user_meta($user->ID, 'user_store', true);
        ?>
        <h3><?php _e('Store Information', 'wp-store-selector'); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="user_store"><?php _e('Store', 'wp-store-selector'); ?></label></th>
                <td>
                    <select name="user_store" id="user_store" class="regular-text">
                        <option value=""><?php _e('Select a store', 'wp-store-selector'); ?></option>
                        <?php foreach ($stores as $store) : ?>
                            <option value="<?php echo esc_attr($store); ?>" <?php selected($selected_store, $store); ?>>
                                <?php echo esc_html($store); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Save store field from user profile
     */
    public function save_store_field_from_profile($user_id) {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        
        if (isset($_POST['user_store'])) {
            update_user_meta($user_id, 'user_store', sanitize_text_field($_POST['user_store']));
        }
    }
} 