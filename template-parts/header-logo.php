<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$custom_logo_id = get_theme_mod('custom_logo');
$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

?>

<img
    class="h-auto w-auto max-w-full max-h-full dark:invert dark:hue-rotate-180"
    src="<?php echo has_custom_logo() ? $logo[0] : documentation_assets('images/logo.svg'); ?>"
    alt="<?php echo esc_attr(sprintf(__('%s Logo', 'documentation'), get_bloginfo('name'))); ?>"
    width="<?php echo has_custom_logo() ?? esc_attr($logo[1]); ?>"
    height="<?php echo has_custom_logo() ?? esc_attr($logo[2]); ?>"
/>