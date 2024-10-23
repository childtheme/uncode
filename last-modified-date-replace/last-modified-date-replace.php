<?php
/*
Plugin Name: Replace Published Date with Last Modified Date
Plugin URI:  https://yourwebsite.com
Description: Replaces the published date with the last modified date on posts and pages.
Version:     1.1
Author:      Dmitrii Chempalov
License:     GPL2
*/

// Hook into 'the_time' filter to change the date display
function replace_published_date_with_modified($date, $d, $post) {
    if ( 'post' === get_post_type($post) ) {
        // Only apply the change for posts
        $modified_date = get_the_modified_date($d, $post);
        return 'Last Updated: ' . $modified_date;
    }
    return $date;
}
add_filter('get_the_date', 'replace_published_date_with_modified', 10, 3);
?>
