<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div data-simplebar class="!sticky top-0 sm:w-72 shrink-0 border-gray-300 text-gray-1000 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start when-md:hidden">
  <ul class="text-sm flex flex-col gap-4">
    <?php foreach ($documents as $index => $document): ?>
      <li>
        <a class="font-bold text-gray-1000 inline-flex justify-start items-center" href="<?php echo esc_attr($document['permalink']); ?>">
          <span class="inline-flex w-5 h-5 justify-center items-center"><?php echo documentation_svg('chevron-right'); ?></span>
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php if (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children']]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>