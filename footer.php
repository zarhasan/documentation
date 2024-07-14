<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package documentation
 */
?>


</main><!-- #content -->

<div class="sr-only live-status-region" role="status"></div>

<footer class="mt-16 border-t-1 bg-gray-0 border-gray-300 border-dashed">
  <div class="x-container flex justify-between items-center py-8 gap-8">
    <a href="<?php echo site_url(); ?>" class="w-40 sm:w-80 py-2 pr-4">
      <?php if(has_custom_logo()): ?>
        <span class="h-14 flex justify-start items-center">
          <?php get_template_part('template-parts/header-logo'); ?>
        </span>
      <?php else: ?>
        <span class="flex justify-start items-start flex-col gap-2">
          <span class="text-sm sm:text-lg font-bold text-gray-900"><?php echo get_bloginfo('name'); ?></span>
        </span>
      <?php endif; ?>
    </a>

    <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_class' => '',
        'menu_class' => 'w-full flex justify-end gap-8 font-medium ml-auto flex-col sm:flex-row',
        'menu_id' => '',
        'fallback_cb' => false,
        'container_aria_label' => 'Primary',
      ));
    ?>
  </div>

  <div class="container">
    <div class="w-full py-8 border-t-1 border-gray-300 border-solid">
      <p class="text-sm text-gray-600">
        <?php echo sprintf(__('All rights reserved %s by %s', 'documentation'), '&copy;', get_bloginfo('name')); ?>
      </p>
    </div>
  </div>

  <?php get_template_part('template-parts/toast'); ?>

</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>