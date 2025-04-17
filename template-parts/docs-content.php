<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

if ($args) {
	extract($args);
}

$author_id = get_the_author_meta('ID');
$theme_options = get_option('documentation_options', documentation_get_default_options());

$isToc = true;
$isSidebar = true;

if(empty($theme_options['single_doc_layout']) && $theme_options['single_doc_layout'] === 'minimal') {
	$isToc = false;
	$isSidebar = false;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

	<div x-data="docsOverlays" class="flex justify-between items-center">
		<button 
			class="origin-left flex justify-end items-center gap-2 text-sm font-semibold text-right transition-all mt-8 <?php echo esc_attr($isSidebar ? '!lg:hidden' : ''); ?>"
			x-on:click="toggleSidebar">
			<span x-show="isNotSidebar" class="w-5 h-5 inline-flex justify-center items-center"><?php echo documentation_svg('layout-sidebar-left-expand'); ?></span>
			<span><?php esc_html_e('All Pages', 'documentation'); ?></span>
		</button>

		<button 
			x-on:click="toggleToc"
			class="flex justify-end items-center gap-2 text-sm font-semibold text-right transition-all mt-8 <?php echo esc_attr($isToc ? '!lg:hidden' : ''); ?>">
			<span x-show="isNotToc" class="w-5 h-5 inline-flex justify-center items-center"><?php echo documentation_svg('list'); ?></span>
			<span><?php esc_html_e('On This Page', 'documentation'); ?></span>
		</button>

		<?php get_template_part('template-parts/docs-content', 'overlays', ['documents' => $documents, 'toc' => $toc]); ?>
	</div>

	<div class="mt-8">
		<h1 class="text-5xl sm:text-7xl entry-title inline"><?php the_title(); ?></h1>
	</div>

	<div class="w-full mt-8 mb-8 pb-6 border-b-1 border-frost-300 border-dashed">
		<div class="text-sm">
			<a class="inline-flex justify-start items-center" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
				<span class="w-4 h-4 inline-flex justify-center items-center mr-2">
					<?php echo documentation_svg('edit'); ?>
				</span>
				<?php echo sprintf(__('Updated on %s', 'documentation'), get_the_modified_date()); ?>
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
