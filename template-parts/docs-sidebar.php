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

      <li 
        data-is-current="<?php echo esc_attr($is_current ? 'true' : 'false'); ?>"
        x-data="docsSidebarItem">
        <div class="flex justify-between items-center gap-2">
          <a class="font-bold grow hover:bg-frost-100 active:bg-frost-200 <?php echo esc_attr($is_current ? 'underline' : '') ?>" href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>            
          </a>

          <?php if (!empty($document['children'])): ?>
            <button 
              x-on:click="toggleExpanded" 
              class="inline-flex w-4 h-4 justify-center items-center shrink-0">
              <span x-show="isNotExpanded" x-cloak>
                <span class="sr-only">
                  <?php echo esc_html__('Expand', 'documentation'); ?> <?php echo esc_html($document['title']); ?>
                </span>
                <?php echo documentation_svg('chevron-right'); ?>
              </span>
              <span x-show="expanded" x-cloak>
                <span class="sr-only">
                  <?php echo esc_html__('Collapse', 'documentation'); ?> <?php echo esc_html($document['title']); ?>
                </span>
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