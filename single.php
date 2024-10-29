<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package documentation
 */

get_header(); ?>


<div class="mx-auto w-full flex justify-start x-container">
	<div id="primary" class="pt-8 lg:pr-8 sm:w-7/12 grow">
		<?php
			/* Start the Loop */
			while (have_posts()):
				the_post();

				get_template_part( 'template-parts/post-content', get_post_format());

				get_template_part( 'template-parts/post', 'navigation');

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;

		?>
	</div>

	<?php get_template_part('template-parts/post', 'sidebar'); ?>
</div><!-- #primary -->


<?php

get_footer();
