Plugin: Replace Published Date with Last Modified Date
Description:
The Replace Published Date with Last Modified Date plugin allows you to replace the default post published date with the last modified date on your WordPress website. This is particularly useful if you want to display the most recent update time for your posts rather than their original publication date.

The plugin hooks into WordPress' date display functionality and replaces the output of the published date with the modified date on both posts and pages. No need to modify theme files directly, and the plugin works seamlessly with most WordPress themes.

Key Features:
Replaces the published date with the last modified date.
Works on posts and pages (easily customizable for other post types).
No direct theme modifications needed.
Lightweight and easy to install.

Install the Plugin:

Go to your WordPress dashboard.
Navigate to Plugins > Add New.
Click the Upload Plugin button at the top.
Select the last-modified-date-replace-updated.zip file you downloaded and click Install Now.
After installation, click Activate Plugin.
Usage:

Once activated, the plugin will automatically replace the published date with the last modified date across your site.
If a post or page has been modified, it will display the modified date instead of the original publication date.
No further configuration is required!
Customization:
Custom Post Types: By default, the plugin applies to regular posts and pages. If you want to modify it for custom post types (such as products or portfolios), edit the code in the plugin file:

Locate the line:

if ( 'post' === get_post_type($post) ) {
Add your custom post type (e.g., 'custom_post_type'):

if ( in_array( get_post_type($post), array('post', 'page', 'custom_post_type') ) ) {
Date Format: If you want to change how the date appears, you can modify the date format by editing this line:


$modified_date = get_the_modified_date($d, $post);
You can pass custom date formats such as F j, Y or Y-m-d as the first parameter for get_the_modified_date().

Deactivation:
If you no longer wish to use the plugin, you can deactivate it from the Plugins section in the WordPress dashboard.
Additional Notes:
Author: Dmitrii Chempalov
Plugin URI: https://github.com/childtheme/uncode
Feel free to contact the author if you need any specific customization or encounter issues while using the plugin.


   
