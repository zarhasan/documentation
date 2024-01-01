<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

get_header(); 

?>

<div class="container grid grid-cols-12 gap-4 mt-16">
  <?php get_template_part('template-parts/sidebar'); ?>

	<div class="col-span-9 pl-8">
    <div>
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
      <div class="flex flex-col gap-12 my-12">
        <?php 
          global $wp_query;

          while (have_posts()): the_post();

          get_template_part('template-parts/document-item');

          endwhile;
        ?>
        
        </div>

        <?php if($wp_query->max_num_pages > 1): ?>
          <?php get_template_part('template-parts/pagination'); ?>
        <?php endif; ?> 

        <?php 
          else:

          get_template_part( 'template-parts/content/none');
        ?>

      </div>

    <?php endif; ?>
  </div>
</div>

<?php
get_footer();
