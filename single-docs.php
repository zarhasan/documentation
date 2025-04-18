<?php
/**
 * The template for displaying all single docs
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package documentation
 */

get_header(); 

$documents = documentation_get_document_hierarchy();
$toc = documentation_get_toc(get_the_content());
$theme_options = get_option('documentation_options', documentation_get_default_options());
?>

<?php if($theme_options['single_doc_layout'] == 'default') : ?>
  <div class="w-full flex justify-start x-container when-md:px-6">
    <?php get_template_part('template-parts/docs', 'sidebar', ['documents' => $documents, 'class' => '!sticky top-0 sm:w-72 shrink-0 border-frost-300 text-frost-1000 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start hidden lg:block']); ?>
    
    <div id="primary" class="pt-8 lg:px-8 !sm:w-7/12 w-full grow">
      <div class="documentation_breadcrumb">
        <?php echo documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->

    <?php get_template_part('template-parts/docs', 'toc', ['toc' => $toc]); ?>
  </div>

<?php elseif($theme_options['single_doc_layout'] == 'minimal') : ?>
  <div class="w-full flex justify-start x-container when-md:px-6">
    <div id="primary" class="pt-8 w-full grow">
      <div class="documentation_breadcrumb">
        <?php echo documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->
  </div>

<?php elseif($theme_options['single_doc_layout'] == 'hide_sidebar') : ?>
  <div class="w-full flex justify-start x-container">
    <div id="primary" class="pt-8 !sm:w-7/12 w-full grow">
      <div class="documentation_breadcrumb">
        <?php echo documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->

    <?php get_template_part('template-parts/docs', 'toc', ['toc' => $toc]); ?>
  </div>
  
<?php elseif($theme_options['single_doc_layout'] == 'hide_toc') : ?>
    
  <div class="w-full flex justify-start x-container">
    <?php get_template_part('template-parts/docs', 'sidebar', ['documents' => $documents, 'class' => '!sticky top-0 sm:w-72 shrink-0 border-frost-300 text-frost-1000 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start hidden lg:block']); ?>
    
    <div id="primary" class="pt-8 lg:pl-8 !sm:w-7/12 w-full grow">
      <div class="documentation_breadcrumb">
        <?php echo documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->
  </div>
<?php endif; ?>

<?php

get_footer();
