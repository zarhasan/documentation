<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="documentation_breadcrumb">
		<?php echo documentation_get_breadcrumb(); ?>
	</div>
	
	<div class="mt-8">
		<?php
			$title = get_the_title();
			$title_words = explode(' ', $title);
			
			usort($title_words, function($a, $b) {
				return strlen($b) - strlen($a);
			});
			
			$largest_length = strlen($title_words[0]);
		?>
		
		<h1 class="text-5xl sm:text-7xl font-semibold entry-title inline <?php echo esc_attr($largest_length > 25 ? 'break-all' : ''); ?>">
			<?php the_title(); ?>
		</h1>
	</div>

	<div class="w-full mt-8 mb-8 pb-6 border-b-1 border-frost-300 border-dashed">
		<div class="text-sm">
			<a class="inline-flex justify-start items-center" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
				<span class="w-4 h-4 inline-flex justify-center items-center mr-2"><?php echo documentation_svg('edit'); ?></span>
				<?php echo sprintf(__('Published on %s', 'documentation'), get_the_date()); ?>
			</a>	
		</div>
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

	<?php get_template_part('template-parts/content/partials/tags'); ?>
</article><!-- #post-## -->
