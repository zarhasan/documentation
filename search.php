<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package documentation
 */

get_header(); ?>

<div class="documentation-container documentation_search_page">
	<div class="x-container flex-grow self-stretch">
		<?php if (have_posts()): ?>
			<div class="posts grid gap-8 my-12 items-start">
				<?php 
					global $wp_query;

					while (have_posts()): the_post();

					get_template_part('template-parts/content/search');

					endwhile;
				?>
			</div>
        <?php if($wp_query->max_num_pages > 1): ?>
            <?php get_template_part('template-parts/pagination'); ?>
        <?php 
            endif; 

            else:

            get_template_part('template-parts/content/none');

            endif;
        ?>
    </div>
</div><!-- .container -->

<?php
get_footer();
