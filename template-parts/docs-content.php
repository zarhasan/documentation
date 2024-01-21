<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> >
	<div class="mt-8 mb-16">
		<h1 class="text-7xl entry-title"><?php the_title(); ?></h1>
	</div>

	<?php if(get_post_thumbnail_id()): ?>
		<div class="relative h-96 flex flex-start items-stretch gap-4 mb-8 mt-8 overflow-hidden">
			<div class="h-full w-full rounded-2xl overflow-hidden">
				<?php get_template_part('template-parts/post-image'); ?>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="entry-content prose">
		<?php
			the_content(
				sprintf(
					wp_kses(
						__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'documentation'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__('Pages:', 'documentation'),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->



	<div class="w-full my-8 flex justify-between items-start">
		<div class="flex justify-start items-start gap-6">
			<div class="flex flex-col items-start justify-start gap-1">
				<p class="text-sm font-semibold inline-flex items-center text-gray-900">
					<?php esc_html_e( 'Published By', 'documentation' ) ?>
				</p>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="text-sm">
					<?php the_author(); ?>
				</a>
			</div>
			<div class="flex flex-col items-start justify-start gap-1">
				<p class="text-sm font-semibold inline-flex items-center text-gray-900">
					<?php esc_html_e( 'Published On', 'documentation' ) ?>
				</p>
				<p class="text-sm">
					<?php the_date('F j, Y'); ?>
				</p>
			</div>
		</div>

		<div class="flex justify-end items-center gap-4">
			<div class="flex justify-end items-center gap-4 text-gray-700">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo the_permalink(); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo documentation_svg('brand-facebook'); ?>
				</a>
				<a href="https://twitter.com/intent/tweet?url=<?php echo the_permalink(); ?>&text=<?php echo the_title(); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo documentation_svg('brand-twitter'); ?>
				</a>
				<a href="https://www.linkedin.com/shareArticle?url=<?php echo the_permalink(); ?>&title=<?php echo the_title(); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo documentation_svg('brand-linkedin'); ?>
				</a>
				<a href="https://api.whatsapp.com/send?text=<?php echo the_title(); ?>%20-%<?php echo the_permalink(); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo documentation_svg('brand-whatsapp'); ?>
				</a>

				<button x-data aria-label="Copy URL" x-on:click="$clipboard('<?php echo the_permalink(); ?>');">
					<?php echo documentation_svg('copy'); ?>
				</button>
			</div>
		</div>
	</div>

	<?php get_template_part('template-parts/content/partials/tags'); ?>
</article><!-- #post-## -->
