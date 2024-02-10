<?php
/**
 * Template Name: Docs
 *
 */

get_header(); 

$documents = get_document_hierarchy();

?>

<div class="w-full">
  <div class="px-10 py-8 grid">
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
