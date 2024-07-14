<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>


<?php if(!empty($documents)): ?>
  <ul class="mt-3 flex flex-col gap-2 text-sm <?php echo isset($level) && $level > 0 ? 'ml-4' : ''; ?>">
    <?php foreach ($documents as $index => $document): ?>
      <li>
        <div class="w-full flex justify-start items-center gap-2 px-4">
          <a 
            class="grow inline-block <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'underline' : '' ?>" 
            href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
          </a>
        </div>

        <?php if ((!empty($document['children']) && get_the_ID() === $document['ID']) || in_array($document['ID'], get_post_ancestors(get_the_ID()))): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>