<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>



<div x-data data-simplebar class="!sticky top-0 sm:w-72 border-gray-300 text-gray-1000 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start when-md:hidden">
  <ul class="text-sm flex flex-col gap-4">
    <?php foreach ($documents as $index => $document): ?>
      <li class="" x-data="{expanded: true}">
        <a class="font-bold text-gray-1000" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php if (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))): ?>
          <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children']]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>