<?php

get_header(); 

$documents = documentation_get_document_hierarchy();
$theme_options = get_option('documentation_options', documentation_get_default_options());

$colors = ['teal', 'purple', 'yellow', 'rose', 'indigo', 'pink', 'amber', 'sky', 'emerald', 'fuchsia', 'lime'];

$faqs_query = new WP_Query([
  'post_type' => 'faq',
  'posts_per_page' => 10
]);

?>

<section class="x-container mt-8"> 
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <?php get_template_part('template-parts/docs-card', null, ['document' => $document, 'color' => $color]); ?>
    <?php endforeach; ?>
  </div>
</section>

<?php
get_footer();
