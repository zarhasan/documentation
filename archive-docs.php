<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

get_header(); 

$documents = get_document_hierarchy();

?>

<?php get_template_part('template-parts/subheader'); ?>

<div class="w-full">

  <div class="container py-20 grid">
    <h1 class="text-8xl"><?php esc_html_e( 'Welcome to our comprehensive documentation', 'documentation' ); ?></h1>
  </div>

	<div class="mt-16 container">
    <div>
      <h2 class="text-6xl mb-4">
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
      </h2>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
      <?php foreach ($documents as $index => $document): ?>
        <div class="mt-3">
          <?php get_template_part('template-parts/docs-item', null, ['document' => $document]); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php
get_footer();
