<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$documents = get_document_hierarchy();

?>



<div class="col-span-3 border-1 rounded-xl border-gray-300 border-solid min-h-screen p-10">
  <ul>
    <?php foreach ($documents as $index => $document): ?>
      <li>
        <a class="font-semibold" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php if(!empty($document['children'])): ?>
          <ul class="mt-3 mb-6 border-l-1 border-gray-200 border-solid flex flex-col gap-2">
            <?php foreach ($document['children'] as $index => $children): ?>
              <li>
                <a 
                  class="hover:text-primary -ml-0.5 pl-4 <?php echo get_the_ID() == $children['ID'] ? 'border-l-2 border-primary text-primary' : 'text-gray-700' ?>" 
                  href="<?php echo esc_attr($children['permalink']); ?>">
                  <?php echo esc_html($children['title']); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>