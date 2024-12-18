# Plugins for Uncode Users 🎉  

Welcome! Below is a curated list of plugins designed to enhance your experience with the **Uncode WordPress Theme**.  

---

## ⚠️ Disclaimer  

> **Please Note**: I am **not an official developer of the Uncode theme**. These plugins are provided "**as is**."  
> 
> ### Important Notice  
> - **Backup Requirement**: Before using any of these plugins, it is essential to create a full backup of your site.  
> - **Usage Agreement**: If you do not agree with this disclaimer, please refrain from using these plugins on your site.  
>
> **Liability**: I am not responsible for any site issues, plugin conflicts, or malfunctions that may occur, and I do not provide support for these plugins.  

---

# Car Park Data Display Plugin

This plugin fetches and displays live car park data via an API using Advanced Custom Fields (ACF). It includes a settings page where you can configure the API URL and display the data on your WordPress site using a shortcode.

---

## Requirements

Before installing, ensure the following plugins are active on your WordPress site:

1. **Advanced Custom Fields (ACF)** or **ACF Pro**  
   - Required to store and display car park data fetched from the API.  
   - [Download ACF](https://wordpress.org/plugins/advanced-custom-fields/)

---

## Installation

1. **Download the Plugin**  
   Download the plugin file from the provided link or source.

2. **Upload and Activate**  
   - Go to your WordPress Admin Dashboard.
   - Navigate to **Plugins > Add New**.
   - Click **Upload Plugin**.
   - Upload the plugin file (`car-park-data-plugin.php`) and click **Install Now**.
   - Once installed, click **Activate**.

---

## Configuration

1. **Set Up API URL**  
   - Go to **Settings > Car Park Data**.
   - Enter the API URL provided by your car park operator (e.g., `https://example.com/carpark/api`).
   - Click **Save Changes**.

2. **Create an ACF Field**  
   - Navigate to **Custom Fields > Add New** in your WordPress Dashboard.
   - Create a new field group and name it **Car Park Data**.
   - Add a field:
     - **Field Label**: Available Spaces
     - **Field Name**: `available_spaces`
     - **Field Type**: Number
   - Assign this field group to the specific page, post, or post type where you want the car park data to be displayed.
   - Save the field group.

---

## Usage

### Display Data Using Shortcode
- Use the shortcode `[car_park_data]` in any page, post, or widget to display live car park data.
- Example output:  
  **Available Spaces: 35**

---

## Automate Updates

This plugin includes functionality to periodically update the ACF field with live data from the API.

### How It Works:
- By default, the plugin fetches data on every page load.
- To improve performance, the plugin schedules hourly updates using WP Cron.
- WP Cron is automatically enabled upon plugin activation.

---

## Instructions Summary (Available in Admin Settings)

- Navigate to **Settings > Car Park Data** for step-by-step instructions and API configuration.
- Use the shortcode `[car_park_data]` to display data dynamically.

---

## Additional Notes

- If you need further customizations (e.g., to display additional API data), extend the plugin by modifying the API fetch function.
- This plugin was created by **Dmitry Chempalov** to simplify live data display for car park operators.
