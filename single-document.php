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


<div class="flex flex-grow self-stretch mb-16">
  <div class="w-3/12 border-r-1 border-gray-300 border-solid min-h-screen p-10 prose">

    <ul>
        <?php foreach ($documents as $index => $document): ?>
          <li>
            <a href="<?php echo esc_attr($document['permalink']); ?>">
              <?php echo esc_html($document['title']); ?>
            </a>

              <ul>
                <?php foreach ($document['headings'] as $index => $heading): ?>
                  <li>
                    <a href="#<?php echo sanitize_title($heading); ?>">
                      <?php echo esc_html($heading); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
          </li>
        <?php endforeach; ?>
    </ul>
  </div>
	
  <div id="primary" class="container">
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
