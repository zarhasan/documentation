<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$image_id = get_post_thumbnail_id();
$image = wp_get_attachment_image_src($image_id, 'large');
$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: get_the_title()." Thumbnail";

if(!$image_id) {
    return;
}

?>

<img 
    src="<?php echo $image ? $image[0] : ''; ?>"
    class="w-full h-full object-cover"
    width="<?php echo esc_attr($image[1] ?? 0); ?>"
    height="<?php echo esc_attr($image[2] ?? 0); ?>"
    alt="<?php echo esc_attr( $image_alt ); ?>"
>