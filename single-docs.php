<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package documentation
 */

get_header(); 

?>

<div class="w-full grid grid-cols-12 gap-4 px-10">
  <?php get_template_part('template-parts/sidebar'); ?>
	
  <div id="primary" class="col-span-7 pt-8 px-8 when-sm:col-span-12">
    <div class="documentation_breadcrumb">
      <?php echo documentation_get_breadcrumb(); ?>
    </div>

    <?php
      /* Start the Loop */
      while (have_posts()):
        the_post();

        get_template_part( 'template-parts/docs', 'content');

        get_template_part( 'template-parts/docs', 'navigation');

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;

      endwhile;

    ?>
  </div><!-- #primary -->

  <?php get_template_part('template-parts/toc'); ?>
</div>



<?php

get_footer();
