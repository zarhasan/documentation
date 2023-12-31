<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package documentation
 */

get_header(); ?>

<div id="primary" class="content-area container flex justify-start items-stretch flex-wrap">
	<div class="lg:w-4/6 grow">
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
	</div>
	<div class="lg:w-2/6 pl-16">
		<?php if ( function_exists( 'echo_crp' ) ) { echo_crp(); } ?>
	</div>
</div><!-- #primary -->


<?php

get_footer();
