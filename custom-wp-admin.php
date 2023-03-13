<?php
/**
 * Plugin Name: Custom /wp-admin Image and URL
 * Plugin URI: https://example.com/plugins/custom-wp-admin-logo
 * Description: A plugin that lets you customize the WordPress admin logo and link.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://bradydavis.io
 */

// Add settings page
function custom_wp_admin_logo_add_settings_page() {
    add_options_page(
        __('Custom WP Admin Logo Settings', 'custom-wp-admin-logo'),
        __('Custom WP Admin Logo', 'custom-wp-admin-logo'),
        'manage_options',
        'custom_wp_admin_logo_settings',
        'custom_wp_admin_logo_settings_page'
    );
}
add_action('admin_menu', 'custom_wp_admin_logo_add_settings_page');

// Register settings
function custom_wp_admin_logo_register_settings() {
    register_setting('custom_wp_admin_logo_settings_group', 'custom_wp_admin_logo_url');
    register_setting('custom_wp_admin_logo_settings_group', 'custom_wp_admin_logo_link');
}
add_action('admin_init', 'custom_wp_admin_logo_register_settings');

// Output custom logo CSS
function custom_wp_admin_logo() {
    ?>
    <style>
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_url(get_option('custom_wp_admin_logo_url', plugin_dir_url(__FILE__) . 'logo.png')); ?>);
            height: 65px;
            width: 320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
    <?php
}
add_action('login_head', 'custom_wp_admin_logo');

// Set custom logo link
function custom_wp_admin_logo_link() {
    return esc_url(get_option('custom_wp_admin_logo_link', 'https://example.com'));
}
add_filter('login_headerurl', 'custom_wp_admin_logo_link');

// Add settings page content
function custom_wp_admin_logo_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Custom WP Admin Logo Settings', 'custom-wp-admin-logo'); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('custom_wp_admin_logo_settings_group'); ?>
            <?php do_settings_sections('custom_wp_admin_logo_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Logo URL', 'custom-wp-admin-logo'); ?></th>
                    <td><input type="text" name="custom_wp_admin_logo_url" value="<?php echo esc_attr(get_option('custom_wp_admin_logo_url')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Link URL', 'custom-wp-admin-logo'); ?></th>
                    <td><input type="text" name="custom_wp_admin_logo_link" value="<?php echo esc_attr(get_option('custom_wp_admin_logo_link')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
