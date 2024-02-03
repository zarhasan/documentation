<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>



<div x-data class="sticky scrollbar top-0 col-span-3 border-gray-300 text-gray-1000 border-solid h-screen overflow-y-scroll py-10 lg:pr-10 self-start when-md:hidden">
  <ul class="text-lg">
    <?php foreach ($documents as $index => $document): ?>
      <li class="mt-3" x-data="{expanded: true}">
        <a class="font-semibold <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'text-primary underline' : 'text-gray-1000' ?>" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children']]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>