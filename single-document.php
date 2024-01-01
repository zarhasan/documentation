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


<div class="container grid grid-cols-12 gap-4 mt-16">

  <?php get_template_part('template-parts/sidebar'); ?>
	
  <div id="primary" class="col-span-6 px-8">
    <?php
      /* Start the Loop */
      while (have_posts()):
        the_post();

        get_template_part( 'template-parts/content', 'document');

        get_template_part( 'template-parts/document', 'navigation');

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
