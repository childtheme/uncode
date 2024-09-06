<?php
/**
 * Plugin Name: Uncode Double Tap Fix
 * Plugin URI:  https://support.undsgn.com/hc/en-us
 * Description: A simple plugin to add the uncode_index_no_double_tap filter.
 * Version:     1.0
 * Author:      Uncode Support Team
 * Author URI:  https://support.undsgn.com/hc/en-us
 * License:     GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Add the uncode_index_no_double_tap filter to return true
add_filter( 'uncode_index_no_double_tap', '__return_true' );
