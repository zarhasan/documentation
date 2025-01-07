<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div data-simplebar class="<?php echo !empty($class) ? $class : ''; ?>">
  <ul class="text-sm flex flex-col gap-8">
    <?php foreach ($documents as $index => $document): ?>
      <?php $is_current = is_singular('docs') && (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))); ?>

      <li x-data="{ expanded: <?php echo $is_current ? 'true' : 'false'; ?> }">
        <div class="flex justify-between items-center gap-2">
          <a class="font-bold grow hover:bg-gray-100 active:bg-gray-200 <?php echo $is_current ? 'underline' : '' ?>" href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>            
          </a>

          <?php if (!empty($document['children'])): ?>
            <button 
              x-on:click="expanded = !expanded" 
              class="inline-flex w-4 h-4 justify-center items-center shrink-0">
              <span x-show="!expanded" x-cloak>
                <?php echo documentation_svg('chevron-right'); ?>
              </span>
              <span x-show="expanded" x-cloak>
                <?php echo documentation_svg('chevron-down'); ?>
              </span>
            </button>
          <?php endif; ?>
        </div>

        <?php if (!empty($document['children'])): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children']]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>