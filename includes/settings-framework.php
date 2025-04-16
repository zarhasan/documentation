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


add_action('wp_ajax_documentation_save_custom_options', 'documentation_save_custom_options');

if (!function_exists('documentation_save_custom_options')) {
    function documentation_save_custom_options() {
        // Verify nonce
        if (!isset($_POST['security']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'documentation_ajax')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }

        // Get and unslash options from POST data
        if (!isset($_POST['options'])) {
            wp_send_json_error(['message' => 'No options provided']);
        }

        $options_raw = wp_unslash($_POST['options']);  // Unslash the options JSON string

        // Decode the JSON options
        $options = json_decode($options_raw, true);

        if (!$options || !is_array($options)) {
            wp_send_json_error(['message' => 'Invalid options data']);
        }

        // Sanitize each field based on its expected type
        $sanitized_options = [];

        if (isset($options['primary_color'])) {
            $sanitized_options['primary_color'] = sanitize_hex_color($options['primary_color']); // Validate and sanitize hex color
        }

        if (isset($options['color_primary_dark'])) {
            $sanitized_options['color_primary_dark'] = sanitize_hex_color($options['color_primary_dark']); // Validate and sanitize hex color
        }

        if (isset($options['default_color_scheme'])) {
            $sanitized_options['default_color_scheme'] = sanitize_text_field($options['default_color_scheme']);
        }

        if (isset($options['docs_home_layout'])) {
            $sanitized_options['docs_home_layout'] = sanitize_text_field($options['docs_home_layout']);
        }

        if (isset($options['docs_page_title'])) {
            $sanitized_options['docs_page_title'] = sanitize_text_field($options['docs_page_title']);
        }

        if (isset($options['docs_page_description'])) {
            $sanitized_options['docs_page_description'] = sanitize_text_field($options['docs_page_description']);
        }

        if (isset($options['footer_copyright_notice'])) {
            $sanitized_options['footer_copyright_notice'] = sanitize_text_field($options['footer_copyright_notice']);
        }

        // Validate user capability
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }

        // Save the sanitized options to the database
        $option_name = 'documentation_options';
        if (update_option($option_name, $sanitized_options)) {
            wp_send_json_success(['message' => 'Options saved successfully']);
        } else {
            wp_send_json_error(['message' => 'Failed to save options']);
        }
    }
}

add_action('wp_ajax_documentation_get_initial_options', 'documentation_get_initial_options');

if(!function_exists('documentation_get_initial_options')) {
    function documentation_get_initial_options() {
        // Verify nonce
        if (!isset($_POST['security']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'documentation_ajax')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }

        // Check if the user has the correct capability to view the settings
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Permission Denied']);
        }

        // Retrieve all plugin settings from the options table
        $settings = get_option('documentation_options', []);

        wp_send_json_success($settings);
    }
}


function documentation_render_settings_page($page_title, $option_name, &$fields) {
    ?>
    <div class="wrap">
        <h1 class="text-2xl font-bold">
            <?php echo esc_html($page_title); ?>
        </h1>

        <div class="bg-white p-8 my-8 border border-gray-300 border-solid">
            <h2 class="mt-0 mb-4"><?php esc_html_e('Settings', 'documentation') ?></h2>
            
            <form class="fast-fuzzy-search-settings" method="post" action="options.php" x-data="optionsForm" x-bind:data-state="state">
                <div x-cloak x-show="state === 'saved'" class="notice notice-success is-dismissible !fixed z-[1000] bottom-4 right-4">
                    <p><?php esc_html_e('Successfully saved the settings.', 'documentation') ?></p>
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
        </div>

        <?php get_template_part('template-parts/admin/plugins'); ?>
        <?php get_template_part('template-parts/admin/pricing'); ?>

    </div>
    <?php
}

