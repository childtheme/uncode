<?php
/*
Plugin Name: Wireframe Import Blocker for Wireframe plugin
Description: A plugin that allows users to block specific elements from demo imports in the Uncode theme.
Version: 1.0
Author: Dmitrii Chemopalov
*/

// Create admin menu

function cdi_add_admin_menu() {
    add_menu_page(
        'Wireframe Import Blocker Settings', 
        'Wireframe Import Blocker', 
        'manage_options', 
        'demo-import-blocker', 
        'cdi_render_settings_page',
        'dashicons-admin-generic'
    );
}
add_action('admin_menu', 'cdi_add_admin_menu');

// Register settings
function cdi_register_settings() {
    register_setting('cdi_settings_group', 'block_media_placeholders');
    register_setting('cdi_settings_group', 'block_team_placeholders');
    register_setting('cdi_settings_group', 'block_quote_placeholders');
    register_setting('cdi_settings_group', 'block_logo_placeholders');
    register_setting('cdi_settings_group', 'block_forms');
}
add_action('admin_init', 'cdi_register_settings');

// Render the settings page
function cdi_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Wireframe Import Blocker Settings</h1>
        <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) { ?>
            <div id="setting-error-settings_updated" class="updated notice notice-success settings-error is-dismissible">
                <p><strong>All changes were made successfully.</strong></p>
            </div>
        <?php } ?>
        <form method="post" action="options.php">
            <?php settings_fields('cdi_settings_group'); ?>
            <?php do_settings_sections('cdi_settings_group'); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Block Media Placeholders</th>
                    <td><input type="checkbox" name="block_media_placeholders" value="1" <?php checked(1, get_option('block_media_placeholders'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Block Team Placeholders</th>
                    <td><input type="checkbox" name="block_team_placeholders" value="1" <?php checked(1, get_option('block_team_placeholders'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Block Quote Placeholders</th>
                    <td><input type="checkbox" name="block_quote_placeholders" value="1" <?php checked(1, get_option('block_quote_placeholders'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Block Logo Placeholders</th>
                    <td><input type="checkbox" name="block_logo_placeholders" value="1" <?php checked(1, get_option('block_logo_placeholders'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Block Wireframe Contact Forms</th>
                    <td><input type="checkbox" name="block_forms" value="1" <?php checked(1, get_option('block_forms'), true); ?> /></td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Apply the block settings via filters
function cdi_apply_filters() {
    if (get_option('block_media_placeholders')) {
        add_filter('uncode_wireframes_get_generic_placeholder_media_id', 'cdi_block_generic_placeholder');
    }

    if (get_option('block_team_placeholders')) {
        add_filter('uncode_wireframes_get_team_placeholder_media_id', 'cdi_block_team_placeholder');
    }

    if (get_option('block_quote_placeholders')) {
        add_filter('uncode_wireframes_get_quote_placeholder_media_id', 'cdi_block_quote_placeholder');
    }

    if (get_option('block_logo_placeholders')) {
        add_filter('uncode_wireframes_get_logo_placeholder_media_id', 'cdi_block_logo_placeholder');
    }

    if (get_option('block_forms')) {
        add_filter('uncode_wireframes_create_forms', '__return_false');
    }
}
add_action('init', 'cdi_apply_filters');

// Placeholder blocking functions
function cdi_block_generic_placeholder($id) {
    $placeholders = array(5065, 5066, 5067);
    return $placeholders[array_rand($placeholders)];
}

function cdi_block_team_placeholder($id) {
    return 5065; // Replace with desired media ID
}

function cdi_block_quote_placeholder($id) {
    return 5065; // Replace with desired media ID
}

function cdi_block_logo_placeholder($id) {
    return 5065; // Replace with desired media ID
}
