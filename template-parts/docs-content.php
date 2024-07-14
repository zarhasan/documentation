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

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> >
	<div class="mt-8">
		<h1 class="text-5xl sm:text-7xl font-semibold entry-title inline"><?php the_title(); ?></h1>
	</div>

	<div class="w-full mt-8 mb-8 pb-6 border-b-1 border-gray-300 border-dashed">
		<div class="text-sm">
			<a class="inline-flex justify-start items-center" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
				<span class="w-4 h-4 inline-flex justify-center items-center mr-2"><?php echo documentation_svg('edit'); ?></span>
				<?php echo sprintf(__('Updated on %s', 'documentation'), get_the_modified_date()); ?>
			</a>	
		</div>
	</div>

	<div x-data="{showSidebar: false, showToc: false}" class="lg:hidden flex justify-between items-center">
		<button 
			class="fixed left-0 top-1/2 -translate-y-1/2 origin-left px-4 py-2 flex justify-end items-center gap-2 text-sm font-semibold bg-gray-0 border-1 border-gray-300 border-solid text-right transition-all"
			x-on:click="showSidebar = !showSidebar"
			x-bind:class="{ 'translate-x-[22.5rem] z-[501]': showSidebar }"
			x-show="!showToc">
			<span x-show="!showSidebar" class="w-6 h-6 inline-flex justify-center items-center"><?php echo documentation_svg('arrow-bar-right'); ?></span>
			<span x-cloak x-show="showSidebar" class="w-6 h-6 inline-flex justify-center items-center"><?php echo documentation_svg('arrow-bar-left'); ?></span>
		</button>

		<div 
			x-show="showSidebar" 
			x-cloak 
			x-on:click.away="showSidebar = false"
			x-on:keydown.escape="showSidebar = false"
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0 -translate-x-28"
			x-transition:enter-end="opacity-100 -translate-x-0"
			x-transition:leave="transition ease-in duration-300"
			x-transition:leave-start="opacity-100 -translate-x-0"
			x-transition:leave-end="opacity-0 -translate-x-28"
			class="!fixed z-[500] bg-gray-50 px-6 py-8 top-32 left-0 w-96 bottom-0 h-screen">
			<?php get_template_part('template-parts/docs', 'sidebar', ['documents' => $documents, 'class' => 'w-full shrink-0 overflow-y-scroll lg:pr-10 lg:hidden']); ?>
		</div>

		<button 
			x-on:click="showToc = !showToc"
			x-bind:class="{ '-translate-x-[22.5rem] z-[501]': showToc }"
			x-show="!showSidebar"
			class="fixed right-0 top-1/2 -translate-y-1/2 px-4 py-2 flex justify-end items-center gap-2 text-sm font-semibold bg-gray-0 border-1 border-gray-300 border-solid text-right transition-all">
			<span x-show="!showToc" class="w-6 h-6 inline-flex justify-center items-center"><?php echo documentation_svg('arrow-bar-left'); ?></span>
			<span x-cloak x-show="showToc" class="w-6 h-6 inline-flex justify-center items-center"><?php echo documentation_svg('arrow-bar-right'); ?></span>
		</button>

		<div 
			data-simplebar
			x-cloak 
			x-show="showToc"
			x-on:click.away="showToc = false"
			x-on:keydown.escape="showToc = false"
			x-on:hashchange.window="showToc = false"
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0 translate-x-28"
			x-transition:enter-end="opacity-100 translate-x-0"
			x-transition:leave="transition ease-in duration-300"
			x-transition:leave-start="opacity-100 translate-x-0"
			x-transition:leave-end="opacity-0 translate-x-28"
			class="documentation_toc !fixed z-[500] bg-gray-50 px-6 py-8 top-32 w-96 right-0 bottom-0 h-screen overflow-y-scroll text-right">
			<?php echo wp_kses_post($toc); ?>
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
