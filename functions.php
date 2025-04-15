<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once get_template_directory() . '/includes/settings-framework.php';
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/lib/BreadcrumbsTrail.php';

define('DOCUMENTATION_VERSION', '__VERSION__');
define('DOCUMENTATION_JOIN_SYMBOL', ' / ');
define('DOCUMENTATION_CACHE_DIR',  WP_CONTENT_DIR . '/cache/documentation/');

// Actions
add_action("after_setup_theme", "documentation_after_setup_theme");
add_action("wp_enqueue_scripts", "documentation_enqueue_scripts");
add_action('tgmpa_register', 'documentation_register_required_plugins');

remove_action('wp_body_open', 'fast_fuzzy_search_render_search_field');

// Filters
add_filter("script_loader_tag", "documentation_add_defer_to_alpine_script", 10, 3);
add_filter('the_content', 'documentation_add_ids_to_headings');

add_filter("acf/settings/save_json", function( $path ) {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function( $paths ) {
    unset($paths[0]);

    $paths[] = get_template_directory() . '/acf-json';
    
    return $paths;
});

add_filter('excerpt_length', function($length) {
    if (is_post_type_archive('docs')) {
        return 10; 
    } else if (get_post_type() === 'post') {
        return 10; 
    } else {
        return $length;
    }
});

add_filter('fast_fuzzy_search_aesthetic', function() {
    return 'newspaper';
}, 10, 2);


add_action('init', function() {
    $add_field = documentation_register_settings_framework(
        __('Documentation', 'documentation'), 
        __('Documentation', 'documentation'), 
        'documentation_options'
    );

    $add_field([
        'id' => 'primary_color',
        'label' => 'Primary Color',
        'type' => 'color_picker',
        'default' => '#31358A',
    ]);

    $add_field([
        'id' => 'color_primary_dark',
        'label' => 'Primary Color (Dark Mode)',
        'type' => 'color_picker',
        'default' => '#6f73cc',
    ]);

    $add_field([
        'id' => 'default_color_scheme',
        'label' => 'Default Color Scheme',
        'type' => 'tabbed_radio',
        'options' => [
            'auto' => [
                'label' => 'Auto',
                'template' => '',
            ],
            'light' => [
                'label' => 'Light',
                'template' => '',
            ],
            'dark' => [
                'label' => 'Dark',
                'template' => '',
            ],
        ],
    ]);

    $add_field([
        'id' => 'docs_home_layout',
        'label' => 'Docs Home Layout',
        'type' => 'tabbed_radio',
        'options' => [
            'default' => [
                'label' => 'Default',
                'template' => '',
            ],
            'quick_links' => [
                'label' => 'Quick Links',
                'template' => '',
            ],
            'search_bar' => [
                'label' => 'Search Bar',
                'template' => '',
            ]
        ],
    ]);

    $add_field([
        'id' => 'docs_page_title',
        'label' => 'Docs Page Title',
        'type' => 'text',
        'default' => __('Documentation', 'documentation'),
    ]);

    $add_field([
        'id' => 'docs_page_description',
        'label' => 'Docs Page Description',
        'type' => 'textarea',
        'default' => __('The fastest way to build documentaion for products', 'documentation'),
    ]);

    $add_field([
        'id' => 'footer_copyright_notice',
        'label' => 'Copyright Notice',
        'type' => 'text',
        'default' => __('All rights reserved %s by %s', 'documentation'),
    ]);

    $settings = get_option('documentation_options', []);
    $default_settings = documentation_get_default_options();
    $updated_settings = array_merge($default_settings, $settings);

    // Update the option only if changes were made
    if ($updated_settings !== $settings) {
        update_option('documentation_options', $updated_settings);
    }

}, 20);


// <Helpers>

if(!function_exists('documentation_get_default_options')) {
    function documentation_get_default_options() {
        return [
            'docs_home_layout' => 'default',
            'primary_color' => '#31358A',
            'color_primary_dark' => '#6f73cc',
            'default_color_scheme' => 'auto',
            'docs_page_title' => __('Documentation', 'documentation'),
            'docs_page_description' => __('The fastest way to build documentaion for products', 'documentation'),
            'footer_copyright_notice' => __('All rights reserved © by %', 'documentation'),
        ];
    };
}

if(!function_exists('documentation_allowed_svg_tags')) {
    function documentation_allowed_svg_tags() {
        return [
            'svg'    => ['xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true, 'class' => true, 'aria-hidden' => true, 'role' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true],
            'g'      => ['fill' => true, 'stroke' => true, 'stroke-width' => true],
            'path'   => ['d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'circle' => ['cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'rect'   => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true],
            'line'   => ['x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true],
            'polyline' => ['points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'polygon'  => ['points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'title'  => [], // Allows adding a title inside SVG
            'desc'   => [], // Allows adding a description inside SVG
            'use'    => ['href' => true, 'x' => true, 'y' => true, 'width' => true, 'height' => true],
            'animatetransform' => [
                'attributename'  => true, 'attributetype' => true, 'type' => true, 
                'from' => true, 'to' => true, 'dur' => true, 'repeatcount' => true, 
                'calcmode' => true, 'values' => true, 'keytimes' => true, 
                'keysplines' => true, 'additive' => true, 'accumulate' => true, 
                'begin' => true, 'end' => true, 'restart' => true, 'fill' => true
            ],
        ];
    }
}

if(!function_exists('documentation_is_pro')) {
    function documentation_is_pro() {
        return true;
    }
}

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
    $version = DOCUMENTATION_VERSION;

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

// </Helpers>

// <Actions>

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
        'secondary' => esc_html__('Secondary', 'documentation'),
        'footer' => esc_html__('Footer', 'documentation'),
    ));
}


function documentation_enqueue_scripts() {
    // Scripts
    wp_enqueue_script('alpine-focus', documentation_assets('js/alpine-focus.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('alpine-collapse', documentation_assets('js/alpine-collapse.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('alpine-intersect', documentation_assets('js/alpine-intersect.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('alpine-csp', documentation_assets('js/alpine-csp.min.js'), array(), documentation_get_version(), false);
    wp_enqueue_script('simplebar', documentation_assets('js/simplebar.min.js'), array(), documentation_get_version(), false);

    wp_enqueue_script('twind', documentation_assets('js/twind.min.js'), array(), documentation_get_version(), false);
    wp_add_inline_script('twind', file_get_contents(get_template_directory(). "/assets/js/head.js"), "after");

    wp_enqueue_script('embla-autoplay', documentation_assets('js/embla-carousel-autoplay.umd.js'), array(), "8.0.0", true);
    wp_enqueue_script('embla', documentation_assets('js/embla-carousel.umd.js'), array(), "8.0.0", true);
    wp_enqueue_script('uFuzzy', documentation_assets('js/uFuzzy.iife.min.js'), array(), '1.0.14', false);

    wp_enqueue_script('documentation-main', documentation_assets('js/main.js'), array('jquery'), documentation_get_version(), true);
    wp_enqueue_style('animxyz', documentation_assets('css/animxyz.min.css'), array(), "0.6.7", 'all');
    wp_enqueue_style('simplebar', documentation_assets('css/simplebar.css'), array(), documentation_get_version(), 'all');
    wp_register_style('documentation-prose', get_template_directory_uri(). '/assets/css/prose.css', array(), documentation_get_version(), 'all');
    wp_enqueue_style('documentation-style', documentation_assets('css/style.css'), array(), documentation_get_version(), 'all');
    
    // Localize
    wp_localize_script('documentation-main', 'documentationData', [
        '_wpnonce' => wp_create_nonce('documentation_ajax'),
        'homeURL' => esc_url(home_url()),
        'assetsURL' => documentation_assets('/'),
        'ajaxURL' => admin_url('admin-ajax.php'),
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    // Extra
    if(is_singular() || is_archive('release-note')) {
        wp_enqueue_style('documentation-prose');
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}


add_action('admin_enqueue_scripts', function() {
    $settings_page_slug = 'documentation_options';
    $screen = get_current_screen();

    if (isset($screen->id) && $screen->id === 'toplevel_page_'.$settings_page_slug) {
        wp_enqueue_script('alpine', documentation_assets('js/alpine.min.js'), array(), documentation_get_version(), false);
        wp_enqueue_script('twind', documentation_assets('js/twind.min.js'), array(), documentation_get_version(), false);
        wp_enqueue_script('documentation-admin', documentation_assets('js/admin.js'), array('jquery'), documentation_get_version(), true);
        
        wp_add_inline_script('twind', file_get_contents(get_template_directory(). "/assets/js/head.js"), "after");

        wp_localize_script('documentation-admin', 'DocumentationData', array(
            '_wpnonce' => wp_create_nonce('documentation_ajax'),
            'homeURL' => esc_url(home_url()),
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }
});


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
            'name'      => 'Code Block Pro - Beautiful Syntax Highlighting',
            'slug'      => 'code-block-pro',
            'required'  => false,
        ),
        array(
            'name'      => 'Fast Fuzzy Search - WordPress & WooCommerce Search Plugin',
            'slug'      => 'fast-fuzzy-search',
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

function documentation_add_defer_to_alpine_script($tag, $handle, $src) {
    $defer_scripts = array('alpine', 'alpine-focus', 'alpine-collapse', 'alpine-intersect', 'alpine-csp');

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}


function documentation_add_ids_to_headings($content) {
    if(get_post_type() == 'post' || get_post_type() == 'docs') {
        $content = preg_replace_callback('/<h([1-6])>(.*?)<\/h\1>/', 'documentation_sanitize_heading_callback', $content);
    }

    return $content;
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


function documentation_get_document_hierarchy_recursive($posts, $post_map, $parent_id = 0) {
    $documents = array();

    foreach ($posts as $post) {
        $post_id = $post->ID;
        $current_parent_id = wp_get_post_parent_id($post_id);

        // If post has the specified parent, add it to the parent's children array
        if ($current_parent_id == $parent_id) {
            $children = documentation_get_document_hierarchy_recursive($posts, $post_map, $post_id);

            $documents[] = array(
                'ID'       => $post_id,
                'title'    => get_the_title($post_id),
                'permalink' => get_the_permalink($post_id),
                'children' => $children,
                'headings' => documentation_get_headings($post->post_content),
                // Add other fields you may need
            );
        }
    }

    return $documents;
};

function documentation_get_document_hierarchy() {
    $args = array(
        'post_type'      => 'docs',
        'posts_per_page' => 10000,
        'orderby'        => 'menu_order',
        'order' => 'ASC',
    );

    if (is_tax('doc_version')) {
        $current_term = get_queried_object();
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'doc_version',
                'field'    => 'term_id', // Use 'slug' if you prefer
                'terms'    => array($current_term->term_id),
                'operator' => 'IN',
            ),
        );
    };

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
    $document_hierarchy = documentation_get_document_hierarchy_recursive($posts, $post_map);

    wp_reset_postdata();

    return $document_hierarchy;
};


function documentation_get_level_2_headings($content) {
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/si', $content, $matches);

    $headings = array();
    foreach ($matches[1] as $heading) {
        $headings[] = strip_tags($heading);
    }

    return $headings;
};

function documentation_get_toc($content) {
    // Match all heading elements (h1 to h6) in the content using a regular expression
    // $pattern = '/<(h[1-6])(.*?)>(.*?)<\/h[1-6]>/i';
    $pattern = '/<(h2)(.*?)>(.*?)<\/h[1-6]>/i';
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
            $heading_id = sanitize_title(strip_tags($heading_text));

            // Get the heading level (e.g., 1, 2, etc.)
            $heading_level = intval(substr($tag, 1));

            while (count($heading_stack) > 0 && end($heading_stack) >= $heading_level) {
                $toc_list .= '</li></ul>';
                array_pop($heading_stack);
            }

            $toc_list .= '<li><a href="#' . $heading_id . '">' . strip_tags($heading_text) . '</a>';

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

function documentation_get_headings($content) {
    $headings = array();

    // Define the regex pattern for matching headings (h1 to h6)
    $pattern = '/<h([1-6])[^>]*>(.*?)<\/h\1>/i';

    // Perform the regex match
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

    // Iterate through the matches and add to the headings array
    foreach ($matches as $match) {
        $headingLevel = $match[1];
        $headingText = strip_tags($match[2]); // Remove HTML tags from heading text
        $sanitizedHeading = sanitize_title($headingText);
        $headings[] = "$headingText";
    }

    return $headings;
}

function documentation_sanitize_heading_callback($matches) {
    // Extract the heading level and text
    $heading_level = $matches[1];
    $heading_text = strip_tags($matches[2]); // Strip HTML tags from heading text

    // Sanitize the heading text to create a valid ID
    $sanitized_heading_text = sanitize_title($heading_text);

    // Generate the ID by combining the heading level and sanitized text
    $heading_id = $sanitized_heading_text;

    // Return the original heading with the added ID
    return "<h$heading_level id=\"$heading_id\">$matches[2]</h$heading_level>";
}

function documentation_flatten_pages_list($pages, $parent_title = null) {
    $titles = [];
    $paths = [];

    foreach ($pages as $i => $page) {
        $page_title = $page['title'];
        $page_path = $page['permalink'];

        if($parent_title != null) {
            $page_title = $parent_title . DOCUMENTATION_JOIN_SYMBOL . $page['title'];
        }

        $titles[] = $page_title;
        $paths[] = $page_path;

        if (!empty($page['headings'])) {
            foreach ($page['headings'] as $j => $heading) {
                $titles[] = $page_title . DOCUMENTATION_JOIN_SYMBOL . $heading;
                $paths[] = $page_path ."#". sanitize_title($heading);
            };
        };

        if (!empty($page['children'])) {
            $recursed = array_merge($titles, documentation_flatten_pages_list($page['children'], $page_title));

            $titles = array_merge($titles, $recursed['titles']);
            $paths = array_merge($paths, $recursed['paths']);
        }
    }

    return [
        'titles' => $titles,
        'paths' => $paths
    ];
}


function documentation_get_breadcrumb()
{
    $args = array(
        'container' => 'nav',
        'before' => '',
        'after' => '',
        'browse_tag' => 'h2',
        'list_tag' => 'ul',
        'item_tag' => 'li',
        'divider' => documentation_svg('chevron-right'),
        'show_on_front' => true,
        'network' => false,
        'show_title' => true,
        'show_browse' => false,
        'labels' => array(
            'browse' => esc_html__('Browse:', 'documentation'),
            'aria_label' => esc_attr_x('Breadcrumbs', 'breadcrumbs aria label', 'documentation'),
            'aria_label_home' => esc_attr_x('Home', 'breadcrumbs aria label', 'documentation'),
            'home' => esc_attr_x('Home', 'breadcrumbs aria label', 'documentation'),
            'error_404' => esc_html__('404 Not Found', 'documentation'),
            'archives' => esc_html__('Archives', 'documentation'),
            'search' => esc_html__('Search results for: %s', 'documentation'),
            'paged' => esc_html__('Page %s', 'documentation'),
            'paged_comments' => esc_html__('Comment Page %s', 'documentation'),
            'archive_minute' => esc_html__('Minute %s', 'documentation'),
            'archive_week' => esc_html__('Week %s', 'documentation'),
            'archive_minute_hour' => '%s',
            'archive_hour' => '%s',
            'archive_day' => '%s',
            'archive_month' => '%s',
            'archive_year' => '%s',
        ),
        'post_taxonomy' => array(
            'docs'  => 'category',
            'docs'  => 'doc_version',
            // 'book'  => 'genre',    // 'book' post type and 'genre' taxonomy
        ),
        'echo' => true,
    );

    $breadcrumb = new BreadcrumbsTrail;
    $breadcrumb->register($args);

    return $breadcrumb->trail();
}

function documentation_recursive_array_search($needle, $haystack, $keyToSearch) {
    foreach ($haystack as $key => $value) {
        if ($key === $keyToSearch && $value === $needle) {
            return $haystack;
        } elseif (is_array($value)) {
            $result = documentation_recursive_array_search($needle, $value, $keyToSearch);
            if ($result !== false) {
                return $result;
            }
        }
    }
    return false;
}