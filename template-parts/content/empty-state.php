<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (isset($args)) {
    extract($args);
}

?>

<section class="documentation_empty-state">
  <div class="documentation_empty-state__svg">
    <?php echo documentation_svg('misc/empty-state'); ?>
  </div>

  <p class="documentation_empty-state__title" role="status">
    <?php echo esc_attr($title) ?: __('Nothing found', 'documentation'); ?>
  </p>
</section>