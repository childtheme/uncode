   <?php
/*
Plugin Name: Rating Banner as Menu Item with Two Images (Modern Design)
Description: Adds a customizable rating banner (two images and optional text) as a menu item in Appearance > Menus with a modern design.
Version: 2.0
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

// Load custom CSS for the options page
function rating_banner_enqueue_admin_styles($hook) {
    if ($hook != 'settings_page_rating-banner-settings') {
        return;
    }

    // Custom inline styles for the modern design with left padding
    echo '
    <style>
        .wrap {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .form-table {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-table th {
            text-align: left;
            font-size: 16px;
            font-weight: 500;
            padding-bottom: 10px;
            color: #333;
            padding: 20px 10px 20px 20px !important; /* Added specific padding */
        }
        .form-table td {
            padding-bottom: 15px;
            padding-left: 20px; /* Added padding on the left */
            padding-right: 20px; /* Added padding on the right */
        }
        input[type="text"],
        input[type="url"],
        input[type="number"] {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #0073aa;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #005a8c;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #444;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        .description {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }
    </style>
    ';
}
add_action('admin_enqueue_scripts', 'rating_banner_enqueue_admin_styles');

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
    register_setting('rating_banner_settings_group', 'rating_banner_first_image');
    register_setting('rating_banner_settings_group', 'rating_banner_second_image');
    register_setting('rating_banner_settings_group', 'rating_banner_link_first_image');
    register_setting('rating_banner_settings_group', 'rating_banner_link_second_image');
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
        'rating_banner_first_image',
        'First Image URL',
        'rating_banner_first_image_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_link_first_image',
        'First Image Link URL (Optional)',
        'rating_banner_link_first_image_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_second_image',
        'Second Image URL',
        'rating_banner_second_image_cb',
        'rating-banner-settings',
        'rating_banner_settings_section'
    );

    add_settings_field(
        'rating_banner_link_second_image',
        'Second Image Link URL (Optional)',
        'rating_banner_link_second_image_cb',
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
    echo '<p>Configure the settings for your rating banner. You can choose to set links or leave them blank to display just images.</p>';
}

// Field callbacks for settings with descriptions
function rating_banner_text_cb() {
    $rating = get_option('rating_banner_text');
    echo '<span class="description">Enter optional text that will appear next to the images (e.g., "Excellent"). Leave it blank if you only want to display the images.</span>';
    echo '<input type="text" name="rating_banner_text" value="' . esc_attr($rating) . '" placeholder="Leave empty to display only images" />';
}

function rating_banner_first_image_cb() {
    $first_image_url = get_option('rating_banner_first_image');
    echo '<span class="description">Provide the URL of the first image to be displayed as the first image in the banner.</span>';
    echo '<input type="text" name="rating_banner_first_image" value="' . esc_url($first_image_url) . '" />';
}

function rating_banner_link_first_image_cb() {
    $first_image_link = get_option('rating_banner_link_first_image');
    echo '<span class="description">(Optional) Enter the URL where the user will be redirected when they click the first image. Leave it blank if you don\'t want the image to be clickable.</span>';
    echo '<input type="url" name="rating_banner_link_first_image" value="' . esc_url($first_image_link) . '" />';
}

function rating_banner_second_image_cb() {
    $second_image_url = get_option('rating_banner_second_image');
    echo '<span class="description">Provide the URL of the second image to be displayed next to the first image.</span>';
    echo '<input type="text" name="rating_banner_second_image" value="' . esc_url($second_image_url) . '" />';
}

function rating_banner_link_second_image_cb() {
    $second_image_link = get_option('rating_banner_link_second_image');
    echo '<span class="description">(Optional) Enter the URL where the user will be redirected when they click the second image. Leave it blank if you don\'t want the image to be clickable.</span>';
    echo '<input type="url" name="rating_banner_link_second_image" value="' . esc_url($second_image_link) . '" />';
}

function rating_banner_height_cb() {
    $height = get_option('rating_banner_height', '20');
    echo '<span class="description">Specify the height (in pixels) for the images in the banner.</span>';
    echo '<input type="number" name="rating_banner_height" value="' . esc_attr($height) . '" /> px';
}

function rating_banner_width_cb() {
    $width = get_option('rating_banner_width', '100');
    echo '<span class="description">Specify the width (in pixels) for the images in the banner.</span>';
    echo '<input type="number" name="rating_banner_width" value="' . esc_attr($width) . '" /> px';
}

// Add custom menu item type
function rating_banner_add_custom_menu_item($items, $args) {
    $rating_text = get_option('rating_banner_text');
    $first_image_url = esc_url(get_option('rating_banner_first_image'));
    $first_image_link = esc_url(get_option('rating_banner_link_first_image'));
    $second_image_url = esc_url(get_option('rating_banner_second_image'));
    $second_image_link = esc_url(get_option('rating_banner_link_second_image'));
    $height = intval(get_option('rating_banner_height', 20));
    $width = intval(get_option('rating_banner_width', 100));

    // Create banner content with two images and optional text
    $banner = '';

    if (!empty($first_image_url)) {
        $banner .= !empty($first_image_link) ? '<a href="' . $first_image_link . '">' : '';
        $banner .= '<img src="' . $first_image_url . '" alt="First Image" height="' . $height . '" width="' . $width . '">';
        $banner .= !empty($first_image_link) ? '</a>' : '';
    }

    if (!empty($second_image_url)) {
        $banner .= !empty($second_image_link) ? '<a href="' . $second_image_link . '">' : '';
        $banner .= '<img src="' . $second_image_url . '" alt="Second Image" height="' . $height . '" width="' . $width . '">';
        $banner .= !empty($second_image_link) ? '</a>' : '';
    }

    if (!empty($rating_text)) {
        $banner .= '<span class="rating-text" style="margin-left: 10px;">' . esc_html($rating_text) . '</span>';
    }

    $items .= '<li class="menu-item rating-banner">' . $banner . '</li>';

    return $items;
}
add_filter('wp_nav_menu_items', 'rating_banner_add_custom_menu_item', 10, 2);
