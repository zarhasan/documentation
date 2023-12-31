<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

<section class="container text-center lg:mt-16">
    <h1 class="text-6xl mb-4"><?php echo esc_html($intro['title']); ?></h1>
    <div class="text-lg mt-3">
        <?php echo wp_kses_post($intro['description']); ?>
    </div>
</section>
