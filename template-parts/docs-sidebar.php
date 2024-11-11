<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div data-simplebar class="<?php echo !empty($class) ? $class : ''; ?>">
  <ul class="text-sm flex flex-col gap-4">
    <?php foreach ($documents as $index => $document): ?>
      <?php $is_current = is_singular('docs') && (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))); ?>

      <li>
        <a class="font-bold flex justify-between items-center hover:bg-gray-100 active:bg-gray-200 <?php echo $is_current ? 'underline' : '' ?>" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>

          <span class="inline-flex w-4 h-4 justify-center items-center shrink-0">
            <?php echo documentation_svg($is_current ? 'chevron-down' : 'chevron-right'); ?>
          </span>
        </a>

        <?php if (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children']]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>