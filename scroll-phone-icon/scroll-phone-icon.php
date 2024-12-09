<?php
/*
Plugin Name: Scroll Phone Icon
Description: Adds a scrollable circle with a phone icon that links to a custom URL. The link, icon, and color can be customized via page options.
Version: 1.3
Author: Dmitrii Chempalov
*/

add_action('admin_menu', 'scroll_phone_icon_add_admin_menu');
add_action('admin_init', 'scroll_phone_icon_settings_init');
add_action('wp_footer', 'scroll_phone_icon_display');

function scroll_phone_icon_add_admin_menu() {
    add_menu_page(
        'Scroll Phone Icon',
        'Scroll Phone Icon',
        'manage_options',
        'scroll_phone_icon',
        'scroll_phone_icon_options_page',
        'dashicons-phone'
    );
}

function scroll_phone_icon_settings_init() {
    register_setting('scrollPhoneIcon', 'scroll_phone_icon_settings');

    add_settings_section(
        'scroll_phone_icon_section',
        __('Settings', 'wordpress'),
        '__return_false',
        'scrollPhoneIcon'
    );

    add_settings_field(
        'scroll_phone_icon_link',
        __('Custom Link', 'wordpress'),
        'scroll_phone_icon_link_render',
        'scrollPhoneIcon',
        'scroll_phone_icon_section'
    );

    add_settings_field(
        'scroll_phone_icon_color',
        __('Circle Color', 'wordpress'),
        'scroll_phone_icon_color_render',
        'scrollPhoneIcon',
        'scroll_phone_icon_section'
    );

    add_settings_field(
        'scroll_phone_icon_class',
        __('Icon Class', 'wordpress'),
        'scroll_phone_icon_class_render',
        'scrollPhoneIcon',
        'scroll_phone_icon_section'
    );

    add_settings_field(
        'scroll_phone_icon_display',
        __('Display On', 'wordpress'),
        'scroll_phone_icon_display_render',
        'scrollPhoneIcon',
        'scroll_phone_icon_section'
    );
}

function scroll_phone_icon_link_render() {
    $options = get_option('scroll_phone_icon_settings');
    ?>
    <input type="url" name="scroll_phone_icon_settings[scroll_phone_icon_link]" value="<?php echo esc_url($options['scroll_phone_icon_link'] ?? '#'); ?>" placeholder="https://yourlink.com" style="width: 100%;">
    <?php
}

function scroll_phone_icon_color_render() {
    $options = get_option('scroll_phone_icon_settings');
    ?>
    <input type="color" name="scroll_phone_icon_settings[scroll_phone_icon_color]" value="<?php echo esc_attr($options['scroll_phone_icon_color'] ?? '#28a745'); ?>">
    <?php
}

function scroll_phone_icon_class_render() {
    $options = get_option('scroll_phone_icon_settings');
    ?>
    <input type="text" name="scroll_phone_icon_settings[scroll_phone_icon_class]" value="<?php echo esc_attr($options['scroll_phone_icon_class'] ?? 'fa fa-phone'); ?>" placeholder="fa fa-phone" style="width: 100%;">
    <?php
}

function scroll_phone_icon_display_render() {
    $options = get_option('scroll_phone_icon_settings');
    $display = $options['scroll_phone_icon_display'] ?? 'mobile';
    ?>
    <select name="scroll_phone_icon_settings[scroll_phone_icon_display]" style="width: 100%;">
        <option value="mobile" <?php selected($display, 'mobile'); ?>>Mobile Only</option>
        <option value="desktop" <?php selected($display, 'desktop'); ?>>Desktop Only</option>
        <option value="both" <?php selected($display, 'both'); ?>>Both</option>
    </select>
    <?php
}

function scroll_phone_icon_options_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Scroll Phone Icon Settings', 'wordpress'); ?></h1>
        <?php
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
                    <p><strong>' . __('Settings saved.', 'wordpress') . '</strong></p>
                  </div>';
        }
        ?>
        <form action="options.php" method="post">
            <?php
            settings_fields('scrollPhoneIcon');
            do_settings_sections('scrollPhoneIcon');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function scroll_phone_icon_display() {
    $options = get_option('scroll_phone_icon_settings');
    $link = esc_url($options['scroll_phone_icon_link'] ?? '#');
    $color = esc_attr($options['scroll_phone_icon_color'] ?? '#28a745');
    $icon_class = esc_attr($options['scroll_phone_icon_class'] ?? 'fa fa-phone');
    $display = $options['scroll_phone_icon_display'] ?? 'mobile';

    ?>
    <style>
        .scroll-phone-icon {
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            width: 60px !important;
            height: 60px !important;
            background-color: <?php echo $color; ?> !important;
            color: #fff !important;
            border-radius: 50% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            cursor: pointer !important;
            z-index: 9999 !important;
            transition: transform 0.3s ease !important;
        }

        .scroll-phone-icon:hover {
            transform: scale(1.1) !important;
        }

        .scroll-phone-icon i {
            font-size: 24px !important;
        }

        /* Display logic based on settings */
        <?php if ($display === 'mobile') : ?>
            @media (min-width: 768px) {
                .scroll-phone-icon {
                    display: none !important;
                }
            }
        <?php elseif ($display === 'desktop') : ?>
            @media (max-width: 767px) {
                .scroll-phone-icon {
                    display: none !important;
                }
            }
        <?php endif; ?>
    </style>
    <a href="<?php echo $link; ?>" class="scroll-phone-icon">
        <i class="<?php echo $icon_class; ?>"></i>
    </a>
    <?php
}
