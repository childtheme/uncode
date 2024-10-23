
<?php
/*
Plugin Name: Grid Cat Filter Links
Description: Allows the user to define grid-cat values and their corresponding URLs.
Version: 1.0
Author: Dmitrii Chempalov
*/

// Hook to add menu item in WordPress admin
add_action('admin_menu', 'grid_cat_filter_menu');

// Create plugin settings menu
function grid_cat_filter_menu() {
    add_options_page(
        'Grid Cat Filter Links Settings', 
        'Grid Cat Filter Links', 
        'manage_options', 
        'grid-cat-filter-links', 
        'grid_cat_filter_settings_page'
    );
}

// Register settings
add_action('admin_init', 'register_grid_cat_filter_settings');

function register_grid_cat_filter_settings() {
    register_setting('grid-cat-filter-settings-group', 'grid_cat_values');
}

// Plugin settings page
function grid_cat_filter_settings_page() {
    ?>
    <div class="wrap">
        <h1>Grid Cat Filter Links Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('grid-cat-filter-settings-group'); ?>
            <?php do_settings_sections('grid-cat-filter-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Grid Cat Values (JSON format)</th>
                    <td><textarea name="grid_cat_values" rows="10" cols="50"><?php echo esc_attr(get_option('grid_cat_values')); ?></textarea></td>
                </tr>
            </table>
            <p>Enter the grid-cat values and their corresponding URLs in the following format:</p>
            <code>{"grid-cat-66": "/category/grid-cat-66", "grid-cat-67": "/category/grid-cat-67"}</code>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue the script to handle dynamic links
add_action('wp_enqueue_scripts', 'grid_cat_filter_enqueue_scripts');

function grid_cat_filter_enqueue_scripts() {
    // Register the script
    wp_enqueue_script('grid-cat-filter-script', plugins_url('/grid-cat-filter.js', __FILE__), array('jquery'), null, true);

    // Pass the grid-cat values from the settings to the JavaScript file
    $grid_cat_values = get_option('grid_cat_values');
    wp_localize_script('grid-cat-filter-script', 'gridCatData', array(
        'catLinks' => json_decode($grid_cat_values, true)
    ));
}
?>
