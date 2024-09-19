<?php
/*
Plugin Name: Rating Banner as Menu Item
Description: Adds a customizable rating banner as a menu item in Appearance > Menus.
Version: 1.0
Author: Dmitrii Chempalov
*/

// Add settings page for the banner
function rating_banner_menu_settings() {
    add_options_page(
        'Rating Banner Settings',
        'Rating Banner',
        'manage_options',
        'rating-banner-settings',
        'rating_banner_settings_page'
    );
}
add_action('admin_menu', 'rating_banner_menu_settings');

// Settings page content
function rating_banner_settings_page() {
    ?>
    <div class="wrap">
        <h1>Rating Banner Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('rating_banner_settings_group');
            do_settings_sections('rating-banner-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and initialize settings
function rating_banner_settings_init() {
    register_setting('rating_banner_settings_group', 'rating_banner_text');
    register_setting('rating_banner_settings_group', 'rating_banner_stars_image');
    register_setting('rating_banner_settings_group', 'rating_banner_link');

    add_settings_section(
        'rating_banner_settings_section',
        'Banner Settings',
        'rating_banner_settings_section_cb',
        'rating-banner-settings'
    );

    add_settings_field(
        'rating_banner_text',
        'Rating Text (e.g., Excellent)',
        'rating_banner_text_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_stars_image',
        'Stars Image URL',
        'rating_banner_stars_image_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_link',
        'Link URL (e.g., Trustpilot)',
        'rating_banner_link_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );
}
add_action('admin_init', 'rating_banner_settings_init');

// Section callback
function rating_banner_settings_section_cb() {
    echo '<p>Configure the settings for your rating banner.</p>';
}

// Field callbacks for settings
function rating_banner_text_cb() {
    $rating = get_option('rating_banner_text');
    echo '<input type="text" name="rating_banner_text" value="' . esc_attr($rating) . '" />';
}

function rating_banner_stars_image_cb() {
    $stars_image_url = get_option('rating_banner_stars_image');
    echo '<input type="text" name="rating_banner_stars_image" value="' . esc_url($stars_image_url) . '" />';
}

function rating_banner_link_cb() {
    $link = get_option('rating_banner_link');
    echo '<input type="url" name="rating_banner_link" value="' . esc_url($link) . '" />';
}

// Add custom menu item type
function rating_banner_add_custom_menu_item($items, $args) {
    // Get the banner settings
    $rating = get_option('rating_banner_text');
    $stars_image_url = get_option('rating_banner_stars_image');
    $link = get_option('rating_banner_link');

    // Create the banner output as a menu item
    if ($rating && $stars_image_url && $link) {
        $banner_html = '<span style="font-size: 16px; margin-right: 10px;">' . esc_html($rating) . '</span>';
        $banner_html .= '<img src="' . esc_url($stars_image_url) . '" alt="Rating stars" style="height: 20px; margin-right: 10px;" />';
        $banner_html .= '<a href="' . esc_url($link) . '" target="_blank" style="font-size: 16px;">Trustpilot</a>';

        // Append to menu items
        $items .= '<li class="menu-item custom-rating-banner">' . $banner_html . '</li>';
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'rating_banner_add_custom_menu_item', 10, 2);
?>
