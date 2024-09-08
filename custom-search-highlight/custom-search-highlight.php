<?php
/*
Plugin Name: Custom Search Highlight
Description: Highlights any searched text in the search results (title, content, excerpt).
Version: 1.0
Author: Dmitrii Chempalov
Author URI: https://github.com/childtheme/uncode
*/


function csh_add_settings_page() {
    add_options_page(
        'Search Highlight Settings',
        'Search Highlight',
        'manage_options',
        'custom-search-highlight',
        'csh_settings_page'
    );
}
add_action('admin_menu', 'csh_add_settings_page');

// Display the settings page
function csh_settings_page() {
    ?>
    <div class="wrap">
        <h1>Search Highlight Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('csh_settings_group');
            do_settings_sections('custom-search-highlight');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and define settings
function csh_register_settings() {
    register_setting('csh_settings_group', 'csh_highlight_color');
    add_settings_section(
        'csh_settings_section',
        'Highlight Settings',
        null,
        'custom-search-highlight'
    );
    add_settings_field(
        'csh_highlight_color',
        'Highlight Color',
        'csh_color_picker_field',
        'custom-search-highlight',
        'csh_settings_section'
    );
}
add_action('admin_init', 'csh_register_settings');

function csh_color_picker_field() {
    $color = get_option('csh_highlight_color', '#ffff00');
    echo '<input type="text" name="csh_highlight_color" value="' . esc_attr($color) . '" class="color-picker" data-default-color="#ffff00" />';
}

// Enqueue color picker scripts and styles
function csh_enqueue_color_picker($hook_suffix) {
    if ($hook_suffix != 'settings_page_custom-search-highlight') {
        return;
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('csh-color-picker', plugins_url('color-picker.js', __FILE__), array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'csh_enqueue_color_picker');

// Function to highlight search terms
function csh_highlight_search_terms($text) {
    if (is_search()) {
        $search_query = get_search_query();
        if ($search_query) {
            $search_terms = explode(' ', preg_quote($search_query));
            $highlight_color = get_option('csh_highlight_color', '#ffff00');
            foreach ($search_terms as $term) {
                if (!empty($term)) {
                    $text = preg_replace("/($term)/i", '<span class="search-highlight" style="background-color:' . esc_attr($highlight_color) . '">$1</span>', $text);
                }
            }
        }
    }
    return $text;
}

add_filter('get_the_excerpt', 'csh_highlight_search_terms', 20);
add_filter('uncode_block_text_out', 'csh_highlight_search_terms', 20);
add_filter('the_title', 'csh_highlight_search_terms', 20);

// Add custom CSS for highlighted terms
function csh_add_custom_styles() {
    echo '<style>
        .search-highlight {
            color: black;
            font-weight: bold;
            padding: 0 2px;
            border-radius: 2px;
        }
    </style>';
}
add_action('wp_head', 'csh_add_custom_styles');
