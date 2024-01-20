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

  <div class="container py-16 grid">
    <h1 class="text-8xl"><?php esc_html_e( 'Welcome to our comprehensive documentation', 'documentation' ); ?></h1>
  </div>

	<div class="mt-8 container">
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
