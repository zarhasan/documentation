<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>


<?php if(!empty($documents)): ?>
  <ul class="mt-3 flex flex-col gap-2 text-sm list-disc <?php echo isset($level) && $level > 0 ? 'ml-4' : ''; ?>">
    <?php foreach ($documents as $index => $document): ?>
      <li x-data="{expanded: false}">
        <div class="w-full flex justify-start items-center gap-2 px-4">
          <a 
            class="grow inline-block <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'underline' : '' ?>" 
            href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
          </a>
        </div>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>