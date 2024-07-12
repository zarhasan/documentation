<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package documentation
 */

get_header(); 

$documents = get_document_hierarchy();

?>

<div class="w-full flex justify-start container when-md:px-6">
  <?php get_template_part('template-parts/sidebar', null, ['documents' => $documents]); ?>
	
  <div id="primary" class="pt-8 lg:px-8 sm:w-7/12 grow">
    <div class="documentation_breadcrumb">
      <?php echo documentation_get_breadcrumb(); ?>
    </div>

    <?php
      /* Start the Loop */
      while (have_posts()):
        the_post();

        get_template_part( 'template-parts/docs', 'content');

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;

      endwhile;

    ?>
  </div><!-- #primary -->

  <?php get_template_part('template-parts/docs', 'toc'); ?>
</div>



<?php

get_footer();
