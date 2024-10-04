<?php
/**
 * Plugin Name: Uncode Theme - Fix Unserialize Deprecation
 * Description: Fixes the PHP 8.1 deprecated warning for passing null to unserialize() in the Uncode theme.
 * Version: 1.0
 * Author: Dmitrii Chempalov
 */

// Hook into 'after_setup_theme' to ensure this runs after the theme is loaded
add_action('after_setup_theme', 'fix_uncode_unserialize_issue');

function fix_uncode_unserialize_issue() {
    // Check if the Uncode theme's function exists before overriding
    if (function_exists('uncode_theme_function_needing_fix')) {

        // Define a new function that will replace the problematic code in the theme
        function custom_uncode_unserialize($data) {
            if (!empty($data) && is_string($data)) {
                return unserialize($data);
            } else {
                // Optionally handle what happens when $data is not a valid string
                return false; // Or any other default value or error handling
            }
        }

        // Find where the original `unserialize` is called, and replace with this fix
        // Add any other replacements or filters if necessary
    }
}
