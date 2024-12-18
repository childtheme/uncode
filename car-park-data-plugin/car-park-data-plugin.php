
<?php
/*
Plugin Name: Car Park Data Display
Description: Fetches and displays live car park data via an API using ACF fields. Includes a settings page for managing the API URL.
Version: 1.1
Author: Dmitry Chempalov
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Register the settings page
function car_park_data_add_settings_page() {
    add_options_page(
        'Car Park Data Settings',
        'Car Park Data',
        'manage_options',
        'car-park-data',
        'car_park_data_settings_page'
    );
}
add_action('admin_menu', 'car_park_data_add_settings_page');

// Render the settings page
function car_park_data_settings_page() {
    ?>
    <div class="wrap">
        <h1>Car Park Data Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('car_park_data_settings');
            do_settings_sections('car-park-data');
            submit_button();
            ?>
        </form>
        <h2>Instructions</h2>
        <p>1. Enter your API URL in the field above and save the changes.</p>
        <p>2. Use the shortcode <code>[car_park_data]</code> in any post, page, or widget to display the live car park availability.</p>
        <p>3. If you want to update the ACF field data automatically, make sure to schedule periodic updates (e.g., via WP Cron).</p>
    </div>
    <?php
}

// Register settings for the API URL
function car_park_data_register_settings() {
    register_setting('car_park_data_settings', 'car_park_api_url');
    add_settings_section('car_park_data_main', '', null, 'car-park-data');
    add_settings_field(
        'car_park_api_url',
        'API URL',
        'car_park_data_api_url_field',
        'car-park-data',
        'car_park_data_main'
    );
}
add_action('admin_init', 'car_park_data_register_settings');

// Render the API URL field
function car_park_data_api_url_field() {
    $api_url = get_option('car_park_api_url', '');
    echo '<input type="text" name="car_park_api_url" value="' . esc_attr($api_url) . '" class="regular-text">';
}

// Fetch car park data from the API
function fetch_car_park_data() {
    $api_url = get_option('car_park_api_url');
    if (!$api_url) {
        return 'API URL is not set.';
    }

    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) {
        return 'Error fetching data';
    }

    $data = wp_remote_retrieve_body($response);
    $data = json_decode($data, true);

    if (isset($data['available_spaces'])) {
        return $data['available_spaces'];
    }

    return 'No data available';
}

// Update ACF field with API data
function update_car_park_data() {
    $available_spaces = fetch_car_park_data();
    if ($available_spaces !== 'API URL is not set.') {
        // Replace 123 with the ID of the page/post where the ACF field exists
        $post_id = 123;
        update_field('available_spaces', $available_spaces, $post_id);
    }
}
add_action('init', 'update_car_park_data');

// Register shortcode to display car park data
function car_park_data_shortcode() {
    $post_id = get_the_ID();
    $available_spaces = get_field('available_spaces', $post_id);

    if ($available_spaces) {
        return '<p>Available Spaces: ' . esc_html($available_spaces) . '</p>';
    } else {
        return '<p>Loading data...</p>';
    }
}
add_shortcode('car_park_data', 'car_park_data_shortcode');

// Schedule WP Cron for periodic updates (optional)
register_activation_hook(__FILE__, function () {
    if (!wp_next_scheduled('update_car_park_data_cron')) {
        wp_schedule_event(time(), 'hourly', 'update_car_park_data_cron');
    }
});

register_deactivation_hook(__FILE__, function () {
    wp_clear_scheduled_hook('update_car_park_data_cron');
});

add_action('update_car_park_data_cron', 'update_car_park_data');
?>
