<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function documentation_register_settings_framework($page_title, $menu_title, $option_name) {
    $fields = [];

    add_action('admin_menu', function() use ($page_title, $menu_title, $option_name, &$fields) {
        documentation_add_settings_page($page_title, $menu_title, $option_name, $fields);
    });

    add_action('admin_init', function() use ($option_name, &$fields) {
        documentation_register_settings($option_name, $fields);
    });

    return function($field) use (&$fields) {
        $fields[] = $field;
    };
}

function documentation_add_settings_page($page_title, $menu_title, $option_name, &$fields) {
    add_menu_page(
        $page_title,
        $menu_title,
        'manage_options',
        $option_name,
        function() use ($page_title, $option_name, &$fields) {
            documentation_render_settings_page($page_title, $option_name, $fields);
        },
        'data:image/svg+xml;base64,' . base64_encode(documentation_svg('custom/file-text')),
    );
}

function documentation_register_settings($option_name, &$fields) {

    register_setting($option_name, $option_name, function($value) use ($fields) {
        return documentation_sanitize_settings($value, $fields); 
    });

    foreach ($fields as $field) {
        add_settings_field(
            $field['id'],
            $field['label'],
            function() use ($field, $option_name) {
                documentation_render_field($field, $option_name);
            },
            $option_name,
            $option_name,
            $field
        );
    }

    add_settings_section($option_name, '', null, $option_name);
}

function documentation_sanitize_settings($value, $field) {
    switch ($field['type']) {
        case 'text':
        case 'number':
        case 'textarea':
            // For text, number, and textarea fields, sanitize and return the value.
            return sanitize_text_field($value);

        case 'checkbox':
            // For checkbox, check if the value is set to '1', otherwise '0'.
            return ($value === '1') ? '1' : '0';

        case 'checkbox_group':
            // For checkbox group, sanitize each selected option.
            if (is_array($value)) {
                return array_map('sanitize_text_field', $value);
            }
            return [];

        case 'radio':
            // For radio buttons, return the selected option value.
            return sanitize_text_field($value);

        case 'select':
            // For select dropdown, return the selected option value.
            return sanitize_text_field($value);

        case 'color_picker':
            // For color picker, sanitize the color value (hex format).
            return sanitize_hex_color($value);

        case 'range':
            // For range, sanitize and return the value within the defined min/max range.
            $min = $field['min'] ?? 0;
            $max = $field['max'] ?? 100;
            $value = intval($value);
            return ($value >= $min && $value <= $max) ? $value : $min;

        case 'switch':
            // For switch (checkbox), sanitize value as a boolean.
            return ($value === '1') ? '1' : '0';

        case 'image_radio':
            // For image radio, return the selected option value.
            return sanitize_text_field($value);

        case 'tabbed_radio':
            // For tabbed radio, return the selected option value.
            return sanitize_text_field($value);

        case 'file':
            // For file input, sanitize the file URL or leave it empty if no file is uploaded.
            return sanitize_file_name($value);

        case 'date':
            // For date input, sanitize and validate the date format (Y-m-d).
            return (preg_match('/\d{4}-\d{2}-\d{2}/', $value)) ? $value : '';

        case 'repeater':
            // For repeater, sanitize each item in the repeater array.
            if (is_array($value)) {
                return array_map(function($item) {
                    return sanitize_text_field($item);
                }, $value);
            }
            return [];
    }

    return $value;
}


function documentation_render_field($field, $option_name) {
    $value = get_option($option_name)[$field['id']] ?? ($field['default'] ?? '');
    $type = $field['type'] ?? 'text';

    switch ($type) {
        default:
            include plugin_dir_path(__FILE__) . 'advanced-fields.php';
            break;
    }
}

function documentation_render_settings_page($page_title, $option_name, &$fields) {
    ?>
    <div class="wrap">
        <h1 class="text-2xl font-bold">
            <?php echo esc_html($page_title); ?>
        </h1>

        <h2 class="mt-8"><?php esc_html_e('Settings', 'fast-fuzzy-search') ?></h2>
        <form class="fast-fuzzy-search-settings" method="post" action="options.php" x-data="optionsForm" x-bind:data-state="state">
            <div x-cloak x-show="state === 'saved'" class="notice notice-success is-dismissible !fixed z-[1000] bottom-4 right-4">
                <p><?php esc_html_e('Successfully saved the settings.', 'fast-fuzzy-search') ?></p>
            </div>

            <div x-cloak x-show="state === 'error'" class="notice notice-error">
                <p><?php esc_html_e('Something went wrong.', 'fast-fuzzy-search') ?></p>
            </div>

            <?php
                settings_fields($option_name);
                do_settings_sections($option_name);
                submit_button();
            ?>
        </form>

        <div class="card max-w-7xl !px-6 py-8">
            <div>
                <div class="mx-auto max-w-2xl ring-1 ring-gray-200 lg:mx-0 lg:flex lg:max-w-none lg:justify-between">
                    <div class="pr-4">
                        <h2 class="text-2xl m-0 font-semibold tracking-tight text-gray-900"><?php esc_html_e('Fast Fuzzy Search Pro', 'fast-fuzzy-search'); ?></h2>
                        <p class="mt-4 text-base/7 text-gray-600">
                            <?php esc_html_e('Unlock the full potential of the fastest search plugin for WordPress. Upgrade to Fast Fuzzy Search Pro today and beat the competition with advanced search features.', 'fast-fuzzy-search'); ?>
                        </p>
                        
                        <div class="mt-4 flex items-center gap-x-4">
                            <h3 class="flex-none text-sm/6 font-semibold text-primary-700">
                                <?php esc_html_e('Get the extra features', 'fast-fuzzy-search'); ?>
                            </h3>
                            <div class="h-px flex-auto bg-gray-100"></div>
                        </div>
                        
                        <ul role="list" class="mt-4 grid grid-cols-1 gap-2 text-sm/6 text-gray-600 sm:grid-cols-2">
                            <li class="flex gap-x-3">
                                <?php echo wp_kses(documentation_svg('check', 'h-6 w-5 flex-none text-primary-700'), documentation_allowed_svg_tags()); ?>
                                <?php esc_html_e('Unlock all themes', 'fast-fuzzy-search'); ?>
                            </li>
                            

                            <li class="flex gap-x-3">
                                <?php echo wp_kses(documentation_svg('check', 'h-6 w-5 flex-none text-primary-700'), documentation_allowed_svg_tags()); ?>
                                <?php esc_html_e('Expanded third-party integration', 'fast-fuzzy-search'); ?>
                            </li>
                        </ul>
                    </div>

                    <div class="-mt-2 p-2 lg:mt-0 lg:w-full lg:max-w-md lg:shrink-0">
                        <div class="bg-gray-50 border border-gray-300 border-solid py-6 text-center ring-1 ring-gray-900/5 ring-inset lg:flex lg:flex-col lg:justify-center">
                            <div class="mx-auto max-w-xs px-8">
                                <p class="text-base font-semibold text-gray-600"><?php esc_html_e('Use on unlimited websites', 'fast-fuzzy-search'); ?></p>
                                <p class="mt-6 flex items-baseline justify-center gap-x-2">
                                    <span class="text-5xl font-semibold tracking-tight text-gray-900">$29</span>
                                    <span class="text-sm/6 font-semibold tracking-wide text-gray-600"><?php esc_html_e('one-time fee', 'fast-fuzzy-search'); ?></span>
                                </p>
                                <a 
                                    href="https://redoxbird.com/product/fast-fuzzy-search/" 
                                    target="_blank"
                                    class="mt-10 block w-full button button-primary">
                                    <?php esc_html_e('Download Now', 'fast-fuzzy-search'); ?>
                                </a>
                                <p class="mt-6 text-xs/5 text-gray-600"><?php esc_html_e('Includes all the features of Fast Fuzzy Search.', 'fast-fuzzy-search') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card max-w-7xl !px-6 py-8">
            <div>
                <div class="mx-auto max-w-2xl ring-1 ring-gray-200 lg:mx-0 lg:flex lg:max-w-none lg:justify-between">
                    <div class="pr-4">
                        <h2 class="text-2xl m-0 font-semibold tracking-tight text-gray-900"><?php esc_html_e('Fast Fuzzy Search Pro + Custom Integration', 'fast-fuzzy-search'); ?></h2>
                        <p class="mt-4 text-base/7 text-gray-600">
                            <?php esc_html_e('Our experts will customize and integrate the solution perfectly with your theme - no technical skills required. Get pixel-perfect implementation that matches your site identity.', 'fast-fuzzy-search'); ?>
                        </p>
                        
                        <div class="mt-4 flex items-center gap-x-4">
                            <h3 class="flex-none text-sm/6 font-semibold text-primary-700"><?php esc_html_e('Features included:', 'fast-fuzzy-search'); ?></h3>
                            <div class="h-px flex-auto bg-gray-100"></div>
                        </div>
                        
                        <ul role="list" class="mt-4 grid grid-cols-1 gap-2 text-sm/6 text-gray-600 sm:grid-cols-2">
                            <li class="flex gap-x-3">
                                <?php echo wp_kses(documentation_svg('check', 'h-6 w-5 flex-none text-primary-700'), documentation_allowed_svg_tags()); ?>
                                <?php esc_html_e('Get custom style that matches your theme', 'fast-fuzzy-search'); ?>
                            </li>

                            <li class="flex gap-x-3">
                                <?php echo wp_kses(documentation_svg('check', 'h-6 w-5 flex-none text-primary-700'), documentation_allowed_svg_tags()); ?>
                                <?php esc_html_e('Seamless integration', 'fast-fuzzy-search'); ?>
                            </li>
                        </ul>
                    </div>

                    <div class="-mt-2 p-2 lg:mt-0 lg:w-full lg:max-w-md lg:shrink-0">
                        <div class="bg-gray-50 border border-gray-300 border-solid py-6 text-center ring-1 ring-gray-900/5 ring-inset lg:flex lg:flex-col lg:justify-center">
                            <div class="mx-auto max-w-xs px-8">
                                <p class="text-base font-semibold text-gray-600">
                                    <?php esc_html_e('White-Glove Integration Service', 'fast-fuzzy-search'); ?>
                                </p>
                                <p class="mt-6 flex items-baseline justify-center gap-x-2">
                                    <span class="text-5xl font-semibold tracking-tight text-gray-900">$299</span>
                                    <span class="text-sm/6 font-semibold tracking-wide text-gray-600"><?php esc_html_e('one-time fee', 'fast-fuzzy-search'); ?></span>
                                </p>
                                
                                <a 
                                    href="https://redoxbird.com/request-integration/" 
                                    target="_blank" 
                                    class="mt-10 block w-full button button-primary">
                                    <?php esc_html_e('Get Custom Integration Now', 'fast-fuzzy-search'); ?>
                                </a>

                                <p class="mt-6 text-xs/5 text-gray-600">
                                    <?php esc_html_e('Includes full Pro features, priority support, and expert implementation', 'fast-fuzzy-search') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
}

