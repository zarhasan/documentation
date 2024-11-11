<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="text-7xl tracking-tight mb-8 mt-16">
		<?php the_title(); ?>
	</h1>

	<div class="entry-content prose mt-8">
		<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'documentation' ),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
