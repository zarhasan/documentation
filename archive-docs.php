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

<div class="w-full">
  <div class="container py-16 grid bg-gray-50 p-10">
    <h1 class="text-7xl mb-8 text-gray-1000"><?php esc_html_e( 'Welcome to our comprehensive documentation', 'documentation' ); ?></h1>

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
