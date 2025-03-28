<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}


?>


<?php if(!empty($documents)): ?>
  <ul
    x-cloak
    x-collapse 
    x-show="expanded"
    class="mt-4 flex flex-col gap-3 text-sm border-l-2 border-frost-1000 border-solid pl-4">
    <?php foreach ($documents as $index => $document): ?>
      <?php $is_current = is_singular('docs') && (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))); ?>

      <li 
        class="w-full" 
        x-data="docsSidebarItem"
        data-is-current="<?php echo esc_attr($is_current ? 'true' : 'false'); ?>">
        <div class="w-full flex justify-start items-center gap-2 <?php echo isset($level) && $level > 1 ? ' pl-4' : ''; ?>">
          <a 
            class="grow flex justify-between items-center text-sm hover:bg-frost-100 active:bg-frost-200 <?php echo esc_attr($is_current ? 'underline' : '') ?>" 
            href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
          </a>

          <?php if (!empty($document['children'])): ?>
            <button 
              x-on:click="toggleExpanded" 
              class="inline-flex w-4 h-4 justify-center items-center shrink-0">
              <span x-show="isNotExpanded" x-cloak>
                <?php echo documentation_svg('chevron-right'); ?>
              </span>
              <span x-show="isExpanded" x-cloak>
                <?php echo documentation_svg('chevron-down'); ?>
              </span>
            </button>
          <?php endif; ?>
        </div>

        <?php if (!empty($document['children'])): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>