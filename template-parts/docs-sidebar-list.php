<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}


?>


<?php if(!empty($documents)): ?>
  <ul class="mt-3 mb-3 flex flex-col gap-3 text-sm <?php echo isset($level) && $level > 0 ? 'ml-4' : ''; ?>">
    <?php foreach ($documents as $index => $document): ?>
      <?php $is_current = is_singular('docs') && (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))); ?>

      <li>
        <div class="w-full flex justify-start items-center gap-2 <?php echo isset($level) && $level > 1 ? ' pl-4' : ''; ?>">
          <a 
            class="grow flex justify-between items-center hover:bg-gray-100 active:bg-gray-200 <?php echo $is_current ? 'underline' : '' ?>" 
            href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
            
            <?php if(!empty($document['children'])): ?>
              <span class="w-4 h-4 inline-flex justify-center items-center shrink-0">
                <?php echo documentation_svg($is_current ? 'chevron-down' : 'chevron-right'); ?>
              </span>
            <?php endif; ?>
          </a>
        </div>

        <?php if ((!empty($document['children']) && get_the_ID() === $document['ID']) || in_array($document['ID'], get_post_ancestors(get_the_ID()))): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>