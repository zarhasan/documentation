<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div class="px-10 h-16 border-b-1 border-gray-300 border-dashed w-full flex justify-between items-center when-sm:hidden">
  <a href="<?php echo home_url(); ?>" class="bg-gray-100 border-1 border-solid border-gray-300 w-10 h-10 inline-flex justify-center items-center text-gray-600 rounded-full">
    <span class="inline-flex justify-center items-center w-4 h-4">
      <?php echo documentation_svg('home'); ?>
    </span>
  </a>
  
  <?php
    wp_nav_menu(array(
      'theme_location' => 'primary',
      'container' => 'nav',
      'container_class' => 'ml-auto',
      'menu_class' => 'w-full flex justify-end gap-4 font-medium',
      'menu_id' => '',
      'fallback_cb' => false,
      'container_aria_label' => 'Primary',
    ));
  ?>
</div>