<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package documentation
 */

get_header(); ?>


<div id="primary" class="content-area px-10 grid grid-cols-12 justify-start items-stretch flex-wrap">
	<div class="col-span-9 grow pr-16">
		<?php
			/* Start the Loop */
			while (have_posts()):
				the_post();

				get_template_part( 'template-parts/content/single', get_post_format());

				get_template_part( 'template-parts/post', 'navigation');

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;

		?>
	</div>

	<?php get_template_part('template-parts/toc'); ?>
</div><!-- #primary -->


<?php

get_footer();
