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

<footer class="mt-16 border-t-1 border-gray-300 border-dashed">
  <div class="x-container flex justify-start items-start">
    <div class="w-8/12 grow py-16">
      <a href="<?php echo site_url(); ?>" class="h-14 inline-flex justify-start items-center bg-gray-0 py-2 rounded-xl when-sm:hidden">
				<?php get_template_part('template-parts/footer-logo'); ?>
			</a>
      <p class="mt-4 text-gray-700"><?php echo esc_html(bloginfo('description')); ?></p>

      <?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container' => 'nav',
					'container_class' => 'when-sm:hidden mt-8',
					'menu_class' => 'w-full flex justify-start gap-8 font-medium',
					'menu_id' => '',
					'fallback_cb' => false,
					'container_aria_label' => 'Primary',
				));
			?>
    </div>

    <div>

    </div>
  </div>

  <div class="container">
    <div class="w-full py-8 border-t-1 border-gray-300 border-solid">
      <p class="text-sm text-gray-600">Copyright © <?php echo date('Y') ?> <?php echo bloginfo('name') ?>.</p>
    </div>
  </div>

  <?php get_template_part('template-parts/toast'); ?>

</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>