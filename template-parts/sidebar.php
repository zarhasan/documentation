<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$documents = get_document_hierarchy();


function documentation_flatten_pages_list($pages, $prefix = '', &$titles = [], &$queries = [], $indexes = []) {
    foreach ($pages as $key => $page) {
        $currentKey = $prefix . ' > ' . $page['title'];

        if (isset($page['children'])) {
            $titles[] = $currentKey;
            $indexes[] = $key;
            $queries[] = '[' . implode("]['children'][", $indexes) . ']';

            documentation_flatten_pages_list($page['children'], $currentKey . "['children']", $titles, $queries, $indexes);
        }

        if (isset($page['headings'])) {
            foreach ($page['headings'] as $headingKey => $headingValue) {
                $titles[] = $currentKey . ' > ' . $headingValue;
                $indexes[] = $key;
                $queries[] = '[' . implode("]['headings'][", $indexes) . "]['headings']" . '[' . $headingKey . ']';
                array_pop($indexes);
            }
        }
    }
}

$titles = [];
$queries = [];

documentation_flatten_pages_list($documents, '', $titles, $queries);

?>



<div class="sticky top-0 col-span-3 border-gray-300 border-solid h-screen pt-16 p-10 self-start">
  <button class="inline-flex justify-start items-center px-6 w-full bg-gray-100 border-1 border-gray-300 border-solid h-16 rounded-full">
    <span class="inline-flex justify-center items-center w-6 h-6 mr-4">
      <?php echo documentation_svg('search'); ?>
    </span>  
    <span><?php esc_html_e('Search In Docs') ?></span>
  </button>

  <ul class="mt-8">
    <?php foreach ($documents as $index => $document): ?>
      <li class="mt-8">
        <a class="font-semibold text-lg" href="<?php echo esc_attr($document['permalink']); ?>">
          <?php echo esc_html($document['title']); ?>
        </a>

        <?php get_template_part('template-parts/sidebar-list', null, ['documents' => $document['children']]); ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
