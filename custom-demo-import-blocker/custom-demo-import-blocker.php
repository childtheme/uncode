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
        'cdi_settings', 
        'cdi_settings_page'
    );
}
add_action( 'admin_menu', 'cdi_add_admin_menu' );

// Settings page content
function cdi_settings_page() {
    ?>
    <div class="wrap">
        <h1>Wireframe Import Blocker Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'cdi_settings_group' );
            do_settings_sections( 'cdi_settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function cdi_register_settings() {
    register_setting( 'cdi_settings_group', 'block_generic_placeholder' );
    register_setting( 'cdi_settings_group', 'block_team_placeholder' );
    register_setting( 'cdi_settings_group', 'block_quote_placeholder' );
    register_setting( 'cdi_settings_group', 'block_logo_placeholder' );
    register_setting( 'cdi_settings_group', 'block_default_placeholders' );
    register_setting( 'cdi_settings_group', 'block_contact_forms' );

    add_settings_section( 'cdi_main_section', 'Select Elements to Block', null, 'cdi_settings' );

    add_settings_field(
        'block_generic_placeholder', 
        'Block Generic Media Placeholder', 
        'cdi_checkbox_callback', 
        'cdi_settings', 
        'cdi_main_section', 
        array( 'name' => 'block_generic_placeholder' )
    );
    add_settings_field(
        'block_team_placeholder', 
        'Block Team Placeholder', 
        'cdi_checkbox_callback', 
        'cdi_settings', 
        'cdi_main_section', 
        array( 'name' => 'block_team_placeholder' )
    );
    add_settings_field(
        'block_quote_placeholder', 
        'Block Quote Placeholder', 
        'cdi_checkbox_callback', 
        'cdi_settings', 
        'cdi_main_section', 
        array( 'name' => 'block_quote_placeholder' )
    );
    add_settings_field(
        'block_logo_placeholder', 
        'Block Logo Placeholder', 
        'cdi_checkbox_callback', 
        'cdi_settings', 
        'cdi_main_section', 
        array( 'name' => 'block_logo_placeholder' )
    );
    add_settings_field(
        'block_default_placeholders', 
        'Block Default Media Placeholders', 
        'cdi_checkbox_callback', 
        'cdi_settings', 
        'cdi_main_section', 
        array( 'name' => 'block_default_placeholders' )
    );
    add_settings_field(
        'block_contact_forms', 
        'Block Wireframe Contact Forms', 
        'cdi_checkbox_callback', 
        'cdi_settings', 
        'cdi_main_section', 
        array( 'name' => 'block_contact_forms' )
    );
}
add_action( 'admin_init', 'cdi_register_settings' );

// Callback for checkboxes
function cdi_checkbox_callback( $args ) {
    $option = get_option( $args['name'] );
    echo '<input type="checkbox" name="' . $args['name'] . '" value="1" ' . checked( 1, $option, false ) . '>';
}

// Add the filters based on settings
function cdi_apply_filters() {
    if ( get_option( 'block_generic_placeholder' ) ) {
        add_filter( 'uncode_wireframes_get_generic_placeholder_media_id', 'uncode_custom_generic_placeholder_media_id' );
    }
    if ( get_option( 'block_team_placeholder' ) ) {
        add_filter( 'uncode_wireframes_get_team_placeholder_media_id', 'uncode_custom_team_placeholder_media_id' );
    }
    if ( get_option( 'block_quote_placeholder' ) ) {
        add_filter( 'uncode_wireframes_get_quote_placeholder_media_id', 'uncode_custom_quote_placeholder_media_id' );
    }
    if ( get_option( 'block_logo_placeholder' ) ) {
        add_filter( 'uncode_wireframes_get_logo_placeholder_media_id', 'uncode_custom_logo_placeholder_media_id' );
    }
    if ( get_option( 'block_default_placeholders' ) ) {
        add_filter( 'uncode_wireframes_create_placeholders_medias', 'uncode_custom_block_import_default_placeholders_medias' );
    }
    if ( get_option( 'block_contact_forms' ) ) {
        add_filter( 'uncode_wireframes_create_forms', 'uncode_custom_block_import_default_forms' );
    }
}
add_action( 'init', 'cdi_apply_filters' );

// Filter functions
function uncode_custom_generic_placeholder_media_id( $id ) {
    $placeholders = array( 5065, 5066, 5067 );
    return $placeholders[ mt_rand( 0, count( $placeholders ) - 1 ) ];
}

function uncode_custom_team_placeholder_media_id( $id ) {
    return 5065;
}

function uncode_custom_quote_placeholder_media_id( $id ) {
    return 5065;
}

function uncode_custom_logo_placeholder_media_id( $id ) {
    return 5065;
}

function uncode_custom_block_import_default_placeholders_medias() {
    return false;
}

function uncode_custom_block_import_default_forms() {
    return false;
}
