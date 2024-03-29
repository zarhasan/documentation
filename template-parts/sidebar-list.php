<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>


<?php if(!empty($documents)): ?>
  <ul x-show="expanded" class="mt-3 flex flex-col gap-2 text-sm <?php echo isset($level) && $level > 0 ? 'ml-4' : ''; ?>">
    <?php foreach ($documents as $index => $document): ?>
      <li x-data="{expanded: false}">
        <div class="w-full flex justify-start items-center gap-2 px-4">
          <a 
            class="grow inline-block <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'text-primary underline' : '' ?>" 
            href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
          </a>

          <?php if(!empty($document['children'])): ?>
            <button
              x-on:click="expanded = !expanded" 
              class="w-6 h-6 p-0.5 shrink-0 inline-flex justify-center items-center rounded-full border-1 border-gray-300 bg-gray-50 border-solid">
              <?php echo documentation_svg('chevron-down'); ?>
            </button>
          <?php endif; ?>
        </div>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>