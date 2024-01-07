<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>


<?php if(!empty($documents)): ?>
  <ul class="mt-3 flex flex-col gap-2 font-semibold text-sm <?php echo isset($level) && $level > 0 ? 'ml-4' : ''; ?>">
    <?php foreach ($documents as $index => $document): ?>
      <li>
        <a 
          class="w-full block rounded-full border-1 hover:bg-gray-100 px-4 py-2 <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'border-primary text-primary bg-primary-100' : 'text-gray-700 border-transparent' ?>" 
          href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>