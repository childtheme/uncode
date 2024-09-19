<?php
/*
Plugin Name: Rating Banner as Menu Item
Description: Adds a customizable rating banner (image and optional text) as a menu item in Appearance > Menus.
Version: 1.0
Author: Dmitri Chempalov
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
    register_setting('rating_banner_settings_group', 'rating_banner_height');
    register_setting('rating_banner_settings_group', 'rating_banner_width');

    add_settings_section(
        'rating_banner_settings_section',
        'Banner Settings',
        'rating_banner_settings_section_cb',
        'rating-banner-settings'
    );

    add_settings_field(
        'rating_banner_text',
        'Optional Rating Text (e.g., Excellent)',
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
        'Link URL (for the clickable image)',
        'rating_banner_link_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_height',
        'Banner Height (in pixels)',
        'rating_banner_height_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_width',
        'Banner Width (in pixels)',
        'rating_banner_width_cb',
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
    echo '<input type="text" name="rating_banner_text" value="' . esc_attr($rating) . '" placeholder="Leave empty to display only image" />';
}

function rating_banner_stars_image_cb() {
    $stars_image_url = get_option('rating_banner_stars_image');
    echo '<input type="text" name="rating_banner_stars_image" value="' . esc_url($stars_image_url) . '" />';
}

function rating_banner_link_cb() {
    $link = get_option('rating_banner_link');
    echo '<input type="url" name="rating_banner_link" value="' . esc_url($link) . '" />';
}

function rating_banner_height_cb() {
    $height = get_option('rating_banner_height', '20'); // Default to 20px if not set
    echo '<input type="number" name="rating_banner_height" value="' . esc_attr($height) . '" /> px';
}

function rating_banner_width_cb() {
    $width = get_option('rating_banner_width', '100'); // Default to 100px if not set
    echo '<input type="number" name="rating_banner_width" value="' . esc_attr($width) . '" /> px';
}

// Add custom menu item type
function rating_banner_add_custom_menu_item($items, $args) {
    // Get the banner settings
    $rating = get_option('rating_banner_text');
    $stars_image_url = get_option('rating_banner_stars_image');
    $link = get_option('rating_banner_link');
    $height = get_option('rating_banner_height', '20'); // Default height
    $width = get_option('rating_banner_width', '100'); // Default width

    // Create the banner output as a menu item
    if ($stars_image_url && $link) {
        $banner_html = '';

        // Only display text if it's set
        if ($rating) {
            $banner_html .= '<span style="font-size: 16px; margin-right: 10px;">' . esc_html($rating) . '</span>';
        }

        // Make the image clickable by wrapping it with a link
        $banner_html .= '<a href="' . esc_url($link) . '" target="_blank"><img src="' . esc_url($stars_image_url) . '" alt="Rating stars" style="height: ' . esc_attr($height) . 'px; width: ' . esc_attr($width) . 'px; margin-right: 10px;" /></a>';

        // Append to menu items
        $items .= '<li class="menu-item custom-rating-banner">' . $banner_html . '</li>';
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'rating_banner_add_custom_menu_item', 10, 2);
?>
