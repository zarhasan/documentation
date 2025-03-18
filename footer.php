<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package documentation
 * 
 */


$theme_options = get_option('documentation');



?>


</main><!-- #content -->

<div class="sr-only live-status-region" role="status"></div>

<footer class="mt-16 border-t-1 bg-frost-0 border-frost-300 border-dashed">
  <div class="x-container flex flex-col !md:justify-between !md:items-center !md:flex-row py-8 gap-8">
    <a href="<?php echo site_url(); ?>" class="w-40 sm:w-80 py-2 pr-4">
      <?php if(has_custom_logo()): ?>
        <span class="h-20 sm:h-14 flex justify-start items-center">
          <?php get_template_part('template-parts/header-logo'); ?>
        </span>
      <?php else: ?>
        <span class="flex justify-start items-start flex-col gap-2">
          <span class="text-sm sm:text-lg font-bold text-frost-900"><?php echo get_bloginfo('name'); ?></span>
        </span>
      <?php endif; ?>
    </a>

    <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_class' => '',
        'menu_class' => 'w-full flex justify-end gap-8 font-medium ml-auto flex-col !sm:flex-row',
        'menu_id' => '',
        'fallback_cb' => false,
        'container_aria_label' => 'Primary',
      ));
    ?>
  </div>

  <div class="x-container">
    <div class="w-full py-8 border-t-1 border-frost-300 border-solid">
      <p class="text-sm text-frost-600">
        <?php echo !empty($theme_options['footer_copyright_notice']) ? $theme_options['footer_copyright_notice'] :  sprintf(__('All rights reserved %s by %s', 'documentation'), '&copy;', get_bloginfo('name')); ?>
      </p>
    </div>
  </div>

  <?php get_template_part('template-parts/toast'); ?>

</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

<?php

if(function_exists('fast_fuzzy_search_get_template_part')) {
  $options = get_option('fast_fuzzy_search_options');
  fast_fuzzy_search_get_template_part('template-parts/search-panel', null, ['is_inline' => true, 'options' => $options]);
};

?>

</body>

</html>