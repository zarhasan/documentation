<?php

require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

define('PIVOTAL_ACCESSIBILITY_VERSION', '0.0.2');

// Actions
add_action("after_setup_theme", "documentation_after_setup_theme");
add_action("wp_enqueue_scripts", "documentation_enqueue_scripts");
add_action('tgmpa_register', 'documentation_register_required_plugins');

// Filters
add_filter("script_loader_tag", "documentation_add_defer_to_alpine_script", 10, 3);
add_filter("acf/settings/save_json", "documentation_acf_json_save_point");
add_filter("acf/settings/load_json", "documentation_acf_json_load_point");


function documentation_dd() {
    echo '<pre>';
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());
    echo '</pre>';
    die;
}

function documentation_truncate($string, $length = 100, $append = "&hellip;") {
    $string = trim($string);

    if (strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
    }

    return $string;
}

function documentation_assets($path) {
    if (!$path) {
        return;
    }

    return get_template_directory_uri() . '/assets/' . $path;
}

function documentation_svg($filename, $class = "") {
    if (!$filename) {
        return;
    }

    $file_location = get_template_directory() . '/assets/icons/' . $filename . '.svg';

    if (!file_exists($file_location)) {
        return;
    }

    $svg_content = file_get_contents($file_location);

    if (!empty($class)) {
        // Check if the SVG has an opening <svg> tag
        if (strpos($svg_content, '<svg') !== false) {
            // Add the class to the opening <svg> tag
            $svg_content = str_replace('<svg', '<svg class="' . esc_attr($class) . '"', $svg_content);
        } else {
            // If the <svg> tag is missing, wrap the content with it and add the class
            $svg_content = '<svg class="' . esc_attr($class) . '">' . $svg_content . '</svg>';
        }
    }

    return $svg_content;
}

function documentation_get_version() {
    $version = PIVOTAL_ACCESSIBILITY_VERSION;

    if (!function_exists('wp_get_environment_type')) {
        return $version;
    }

    switch (wp_get_environment_type()) {
        case 'local':
        case 'development':
            $version = time();
            break;
    }

    return $version;
}

function documentation_add_defer_to_alpine_script($tag, $handle, $src) {
    $defer_scripts = array('documentation-alpine', 'documentation-alpine-focus', 'documentation-alpine-collapse', 'documentation-alpine-intersect');

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}


function documentation_enqueue_scripts() {
    // Scripts
    wp_enqueue_script('documentation-alpine-focus', documentation_assets('js/alpine-focus.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('documentation-alpine-collapse', documentation_assets('js/alpine-collapse.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('documentation-alpine-intersect', documentation_assets('js/alpine-intersect.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('documentation-alpine', documentation_assets('js/alpine.min.js'), array(), documentation_get_version(), false);

    wp_enqueue_script('documentation-twind', documentation_assets('js/twind.min.js'), array(), documentation_get_version(), false);
    wp_add_inline_script('documentation-twind', file_get_contents(get_template_directory(). "/assets/js/head.js"), "after");

    wp_enqueue_script('embla-autoplay', documentation_assets('js/embla-carousel-autoplay.umd.js'), array(), "8.0.0", true);
    wp_enqueue_script('embla', documentation_assets('js/embla-carousel.umd.js'), array(), "8.0.0", true);
    wp_enqueue_script('toastify', documentation_assets('js/toastify.js'), array(), "5.3.0", true);

    wp_enqueue_script('documentation-main', documentation_assets('js/main.js'), array('jquery'), documentation_get_version(), true);
    wp_enqueue_style('animxyz', documentation_assets('css/animxyz.min.css'), array(), "0.6.7", 'all');
    wp_enqueue_style('documentation-style', documentation_assets('css/style.css'), array(), documentation_get_version(), 'all');
   
    // Localize
    wp_localize_script('documentation-main', 'documentationData', [
        '_wpnonce' => wp_create_nonce('documentation_ajax'),
        'homeURL' => esc_url(home_url()),
        'assetsURL' => esc_url(documentation_assets('/')),
        'ajaxURL' => esc_url(admin_url('admin-ajax.php')),
    ]);

    // Extra
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}


function documentation_after_setup_theme() {
    /*
    * Default Theme Support options better have
    */
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /**
     * Add woocommerce support and woocommerce override
     */

    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width' => 1024,
        'product_grid' => array(
            'default_rows' => 3,
            'min_rows' => 3,
            'max_rows' => 3,
            'default_columns' => 4,
            'min_columns' => 4,
            'max_columns' => 4,
        ),
    ));

    $GLOBALS['content_width'] = apply_filters('content_width', 1920);

    register_nav_menus(array(
        'primary' => esc_html__('Primary', 'documentation'),
        'footer' => esc_html__('Footer', 'documentation'),
        'legal' => esc_html__('Legal', 'documentation'),
    ));
}


function documentation_kses_ruleset() {
    $kses_defaults = wp_kses_allowed_html('post');

    $svg_args = array(
        'svg' => array(
            'class' => true,
            'aria-hidden' => true,
            'aria-labelledby' => true,
            'stroke-width' => true,
            'stroke' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
            'fill' => true,
            'role' => true,
            'xmlns' => true,
            'width' => true,
            'height' => true,
            'viewbox' => true, // <= Must be lower case!
        ),
        'g' => array('fill' => true),
        'title' => array('title' => true),
        'path' => array(
            'd' => true,
            'fill' => true,
            'stroke' => true,
        ),
        'line' => array(
            "x1" => true,
            "y1" => true,
            "x2" => true,
            "y2" => true
        ),
        'polyline' => array(
            'points' => true
        )
    );

    return array_merge($kses_defaults, $svg_args);
}


function documentation_acf_json_save_point( $path ) {
    return get_template_directory() . '/acf-json';
}

function documentation_acf_json_load_point( $paths ) {
    // Remove the original path (optional).
    unset($paths[0]);

    // Append the new path and return it.
    $paths[] = get_template_directory() . '/acf-json';

    return $paths;
}


function documentation_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'Advanced Custom Fields (ACF)',
            'slug'      => 'advanced-custom-fields',
            'required'  => false,
        ),
        array(
            'name'      => 'Nested Pages',
            'slug'      => 'wp-nested-pages',
            'required'  => false,
        ),
        array(
            'name'      => 'WP Githuber MD',
            'slug'      => 'wp-githuber-md',
            'required'  => false,
        )
    );

    $config = array(
        'id'           => 'documentation', // Unique ID for TGMPA
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins', // Menu slug
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '', // Customize the dismissal message
        'is_automatic' => true,
        'message'      => '', // Customize the notice message
    );

    tgmpa($plugins, $config);
}

class Pivotal_Accessibility_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        // Add a button after the list item's opening tag
        $output .= '<button class="menu-toggle w-6" aria-expanded="false" aria-label="'.__('Toggle sub-menu', 'documentation').'">';
        $output .= '<span class="menu-toggle-icon" aria-hidden="true">'.documentation_svg('chevron-down').'</span>';
        $output .= '</button>';
        
        $output .= '<ul class="sub-menu">';
    }
}

// Kirki

if (class_exists('Kirki')) {
    // Appearance
    new \Kirki\Panel(
        'appearance',
        [
            'priority'    => 20,
            'title'       => esc_html__('Appearance', 'documentation'),
            'description' => esc_html__('Change the appearance of the theme.', 'documentation'),
        ]
    );

    new \Kirki\Section(
        'colors',
        [
            'title'       => esc_html__('Colors', 'documentation'),
            'description' => esc_html__('Customize the colors of the theme.', 'documentation'),
            'panel'       => 'appearance',
            'priority'    => 160,
        ]
    );

    new \Kirki\Field\Color(
        [
            'settings'    => 'color_primary',
            'label'       => __('Primary Color', 'documentation'),
            'description' => esc_html__('Primary color of the theme.', 'documentation'),
            'section'     => 'colors',
            'default'     => '#1d0370',
        ]
    );

    // Header
    new \Kirki\Section(
        'header',
        [
            'priority'    => 40,
            'title'       => esc_html__('Header', 'documentation'),
            'description' => esc_html__('Customize the header.', 'documentation'),
        ]
    );

    new \Kirki\Field\Text(
        [
            'settings'    => 'form_shortcode',
            'label'       => esc_html__('Form Shortcode', 'documentation'),
            'section'     => 'header',
        ]
    );

    // Global
    new \Kirki\Section(
        'global',
        [
            'priority'    => 40,
            'title'       => esc_html__('Global', 'documentation'),
            'description' => esc_html__('Customize the global settings.', 'documentation'),
        ]
    );

    new \Kirki\Field\Repeater(
        [
            'settings' => 'client_logos',
            'label'    => esc_html__('Client Logos', 'documentation'),
            'section'  => 'global',
            'button_label' => esc_html__('Add New Logo', 'documentation'),
            'fields'   => [
                'image'  => [
                    'type'        => 'image',
                    'label'       => esc_html__('Logo', 'documentation'),
                    'default'     => '',
                    'choices'     => [
                        'save_as' => 'array',
                    ],
                ]
            ],
        ]
    );

    // Contact Info
    new \Kirki\Section(
        'contact_info',
        [
            'priority'    => 45,
            'title'       => esc_html__('Contact Info', 'documentation'),
            'description' => esc_html__('Customize the contact info.', 'documentation'),
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'branch_address',
            'label'       => esc_html__('Branch Address', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'registered_address',
            'label'       => esc_html__('Registered Address', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'us_address',
            'label'       => esc_html__('US Address', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'phone_number_india',
            'label'       => esc_html__('Phone Number (India)', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'phone_number_us',
            'label'       => esc_html__('Phone Number (US)', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'email_address',
            'label'       => esc_html__('Email Address', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Text(
        [
            'settings'    => 'main_address_url',
            'label'       => esc_html__('Main Address URL', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    new \Kirki\Field\Image(
        [
            'settings'    => 'main_address_image',
            'label'       => esc_html__('Main Address Image', 'documentation'),
            'section'     => 'contact_info',
        ]
    );

    // Footer
    new \Kirki\Panel(
        'footer',
        [
            'priority'    => 50,
            'title'       => esc_html__('Footer', 'documentation'),
            'description' => esc_html__('Customize the footer.', 'documentation'),
        ]
    );

    new \Kirki\Section(
        'footer_content',
        [
            'title'       => esc_html__('Content', 'documentation'),
            'description' => esc_html__('Change the content of the footer.', 'documentation'),
            'panel'       => 'footer',
            'priority'    => 160,
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'footer_description',
            'label'       => esc_html__('Footer Description', 'documentation'),
            'section'     => 'footer_content',
            'default'     => 'Established in 2021, Documentation was formed with the sole purpose of making the Digital World more inclusive.',
        ]
    );

    new \Kirki\Field\Repeater(
        [
            'settings' => 'footer_logos',
            'label'    => esc_html__('Logos', 'documentation'),
            'section'  => 'footer_content',
            'button_label' => esc_html__('Add New Logo', 'documentation'),
            'fields'   => [
                'image'  => [
                    'type'        => 'image',
                    'label'       => esc_html__('Logo', 'documentation'),
                    'default'     => '',
                    'choices'     => [
                        'save_as' => 'array',
                    ],
                ],
                'url'  => [
                    'type'  => 'url',
                    'label' => esc_html__('Logo Link', 'documentation'),
                ],
            ],
        ]
    );

    new \Kirki\Field\Repeater(
        [
            'settings' => 'social_icons',
            'label'    => esc_html__('Social Icons', 'documentation'),
            'section'  => 'footer_content',
            'button_label' => esc_html__('Add New Icon', 'documentation'),
            'row_label' => [
                'type'  => 'field',
                'field' => 'label',
            ],
            'fields' => [
                'name' => [
                    'type'        => 'text',
                    'default'     => 'brand-facebook',
                    'label'       => esc_html__('Icon Name (Tabler Icons)', 'documentation'),
                ],
                'label' => [
                    'type'        => 'text',
                    'label'       => esc_html__('Icon Label', 'documentation'),
                    'default'     => esc_html__('Facebook', 'documentation')
                ],
                'url' => [
                    'type'        => 'url',
                    'label'       => esc_html__('Icon Link', 'documentation'),
                    'default'     => 'https://example.com/',
                ],
            ],
        ]
    );

    new \Kirki\Field\Repeater(
        [
            'settings' => 'footer_features',
            'label'    => esc_html__('Footer Features', 'documentation'),
            'section'  => 'footer_content',
            'button_label' => esc_html__('Add New', 'documentation'),
            'row_label' => [
                'type'  => 'field',
                'field' => 'label',
            ],
            'fields' => [
                'icon' => [
                    'type'        => 'text',
                    'default'     => 'mail-fast',
                    'label'       => esc_html__('Icon Name (Tabler Icons)', 'documentation'),
                ],
                'label' => [
                    'type'        => 'text',
                    'label'       => esc_html__('Label', 'documentation'),
                    'default'     => esc_html__('Fast', 'documentation')
                ],
                'description' => [
                    'type'        => 'textarea',
                    'label'       => esc_html__('Description', 'documentation'),
                    'default'     => esc_html__('We deliver fast and efficient service', 'documentation'),
                ],
            ],
        ]
    );

    new \Kirki\Field\Editor(
        [
            'settings'    => 'copyright_notice',
            'label'       => esc_html__('Copyright Notice', 'documentation'),
            'section'     => 'footer_content',
        ]
    );
};


function get_document_hierarchy_recursive($posts, $post_map, $parent_id = 0) {
    $documents = array();

    foreach ($posts as $post) {
        $post_id = $post->ID;
        $current_parent_id = wp_get_post_parent_id($post_id);

        // If post has the specified parent, add it to the parent's children array
        if ($current_parent_id == $parent_id) {
            $children = get_document_hierarchy_recursive($posts, $post_map, $post_id);

            $documents[] = array(
                'ID'       => $post_id,
                'title'    => get_the_title($post_id),
                'permalink' => get_the_permalink($post_id),
                'children' => $children,
                'headings' => getHeadingsFromContent($post->post_content),
                // Add other fields you may need
            );
        }
    }

    return $documents;
};

function get_document_hierarchy() {
    $args = array(
        'post_type'      => 'document',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order' => 'ASC',
    );

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return array(); // No documents found
    }

    $posts = $query->posts;

    // Create a map to easily find posts by ID
    $post_map = array();
    foreach ($posts as $post) {
        $post_map[$post->ID] = $post;
    }

    // Start the recursive process
    $document_hierarchy = get_document_hierarchy_recursive($posts, $post_map);

    wp_reset_postdata();

    return $document_hierarchy;
};


function getHeadingsFromContent($content) {
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/si', $content, $matches);

    $headings = array();
    foreach ($matches[1] as $heading) {
        $headings[] = strip_tags($heading);
    }

    return $headings;
};

function documentation_get_toc($content) {
    // Match all heading elements (h1 to h6) in the content using a regular expression
    $pattern = '/<(h[1-6])(.*?)>(.*?)<\/h[1-6]>/i';
    preg_match_all($pattern, $content, $headings);

    // Check if any headings were found
    if (!empty($headings[0])) {
        $toc_list = '<nav role="navigation" class="table-of-contents"><h2>On This Page</h2><ul>';
        $heading_stack = array();

        // Loop through each heading and add an ID attribute
        for ($i = 0; $i < count($headings[0]); $i++) {
            $tag = $headings[1][$i]; // The heading tag (e.g., 'h1', 'h2', etc.)
            $attributes = $headings[2][$i]; // Any additional attributes in the heading tag
            $heading_text = $headings[3][$i]; // The text inside the heading

            // Generate an ID using the sanitize_title() function
            $heading_id = sanitize_title($heading_text);

            // Get the heading level (e.g., 1, 2, etc.)
            $heading_level = intval(substr($tag, 1));

            while (count($heading_stack) > 0 && end($heading_stack) >= $heading_level) {
                $toc_list .= '</li></ul>';
                array_pop($heading_stack);
            }

            $toc_list .= '<li><a href="#' . $heading_id . '">' . $heading_text . '</a>';

            if (count($heading_stack) === 0 || end($heading_stack) < $heading_level) {
                $toc_list .= '<ul>';
                $heading_stack[] = $heading_level;
            }
        }

        // Close any remaining nested lists
        while (count($heading_stack) > 0) {
            $toc_list .= '</li></ul>';
            array_pop($heading_stack);
        }

        $toc_list .= '</ul></nav>';

        return $toc_list;
    }

    return false;
};