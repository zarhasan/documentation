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


<div class="flex flex-grow self-stretch mb-16">
  <div class="w-3/12 border-r-1 border-gray-300 border-solid min-h-screen p-10 prose">

    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
	
  <div id="primary" class="container pt-16">
    <?php
      /* Start the Loop */
      while (have_posts()):
        the_post();

        get_template_part( 'template-parts/content/single', get_post_format());

        get_template_part( 'template-parts/content/single', 'navigation');

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;

      endwhile;

    ?>
  </div><!-- #primary -->
</div>



<?php

get_footer();
