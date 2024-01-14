<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$documents = get_document_hierarchy();

?>



<div x-data class="sticky top-0 col-span-3 border-gray-300 border-solid h-screen pt-16 pr-10 self-start when-sm:hidden">
  <button x-on:click="$store.searchPanel.show()" class="inline-flex justify-start items-center px-6 w-full bg-gray-100 border-1 border-gray-300 border-solid h-16 rounded-full">
    <span class="inline-flex justify-center items-center w-6 h-6 mr-4">
      <?php echo documentation_svg('search'); ?>
    </span>  
    <span><?php esc_html_e('Search In Docs') ?></span>
  </button>

  <ul class="mt-8 text-lg">
    <?php foreach ($documents as $index => $document): ?>
      <li class="mt-3">
        <a class="font-semibold <?php echo is_singular('docs') && get_the_ID() === $document['ID'] ? 'text-primary underline' : '' ?>" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children']]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>