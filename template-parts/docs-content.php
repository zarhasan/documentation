<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */


$author_id = get_the_author_meta('ID');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> >
	<div class="mt-8">
		<h1 class="text-7xl font-semibold entry-title inline"><?php the_title(); ?></h1>
	</div>

	<div class="w-full mt-8 mb-12 pb-6 border-b-1 border-gray-300 border-dashed">
		<div class="text-sm">
			<a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
				<?php echo sprintf(__('Written by %s', 'documentation'), get_the_author()); ?>
			</a>	

			<span><?php echo sprintf(__('on %s', 'documentation'), get_the_date('F j, Y')); ?></span>
		</div>
	</div>

	<div class="lg:hidden flex justify-between items-center gap-8 mb-8">
		<button class="px-4 py-2 flex justify-end items-center gap-2 text-sm font-semibold rounded-full bg-gray-50 border-1 border-gray-300 border-solid text-right">
			<?php esc_html_e('Sidebar', 'documentation'); ?>
			<span class="w-6 h-6 inline-flex justify-center items-center"><?php echo documentation_svg('chevron-right-pipe'); ?></span>
		</button>
		<button class="px-4 py-2 flex justify-end items-center gap-2 text-sm font-semibold rounded-full bg-gray-50 border-1 border-gray-300 border-solid text-right">
			<span class="w-6 h-6 inline-flex justify-center items-center"><?php echo documentation_svg('chevron-left-pipe'); ?></span>
			<?php esc_html_e('Table Of Contents', 'documentation'); ?>
		</button>
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
