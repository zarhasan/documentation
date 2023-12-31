<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

get_header(); ?>

<div id="primary" class="content-area">
<?php $card_type = get_theme_mod('blog_card_type', 'default'); ?>

<div class="container flex-grow self-stretch mb-16">

	<div class="text-center mt-16">
		<h1 class="text-6xl mb-4">
			<?php
				$archive_title = 'Archive';
				if (is_category()) {
					$archive_title = get_the_archive_title();
				} elseif (is_tag()) {
					$archive_title = get_the_archive_title();
				} elseif (is_author()) {
					$archive_title = get_the_archive_title();
				} elseif (is_date()) {
					$archive_title = get_the_archive_title();
				} elseif (is_post_type_archive()) {
					$archive_title = post_type_archive_title('', false);
				} elseif (is_tax()) {
					$archive_title = single_term_title('', false);
				} else {
					$archive_title = 'Archive';
				}
			?>

			<?php echo wp_kses_post($archive_title); ?>
		</h1>
	</div>
	
	<?php if (have_posts()): ?>
	<div class="posts flex flex-col gap-12 my-12">

		<?php 
			global $wp_query;

			while (have_posts()): the_post();

			get_template_part('template-parts/post-card', $card_type.get_post_format());

			endwhile;
		?>
		</div>

		<?php if($wp_query->max_num_pages > 1): ?>
			<?php get_template_part('template-parts/pagination'); ?>
		<?php 
			endif; 

			else:

			get_template_part( 'template-parts/content/none');

			endif;
		?>

	</div>
</div>

<?php
get_footer();
