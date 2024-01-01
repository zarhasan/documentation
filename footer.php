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

<footer class="mt-16 py-8 border-t-1 border-gray-300 border-solid">
  <p class="text-center text-sm text-gray-600">Copyright © <?php echo date('Y') ?> <?php echo bloginfo('name') ?>.</p>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>