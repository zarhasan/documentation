<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$documents = get_document_hierarchy();

?>



<div x-data class="sticky top-0 col-span-3 border-gray-300 border-solid h-screen overflow-y-scroll pt-8 pr-10 self-start when-sm:hidden">
  <ul class="text-lg">
    <?php foreach ($documents as $index => $document): ?>
      <li class="mt-3">
        <a class="font-semibold <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'text-primary underline' : '' ?>" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children']]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>