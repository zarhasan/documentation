<?php

get_header(); 

$documents = documentation_get_document_hierarchy();
$theme_options = get_option('documentation_options', documentation_get_default_options());

$colors = ['teal', 'purple', 'yellow', 'rose', 'indigo', 'pink', 'amber', 'sky', 'emerald', 'fuchsia', 'lime'];
?>

<section class="x-container mt-8"> 
  <div class="grid grid-cols-1 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <?php get_template_part('template-parts/docs-list-card', null, ['document' => $document, 'color' => $color]); ?>
    <?php endforeach; ?>
  </div>
</section>

<?php
get_footer();
