<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$parent_id = wp_get_post_parent_id(get_the_ID());
$siblings = [];
$children = [];
$items = $documents;

$result = [];

if($parent_id) {
    $result = documentation_recursive_array_search($parent_id, $documents, 'ID');
    $items = $result['children'];
}

if($parent_id === 0) {
    $result = documentation_recursive_array_search(get_the_ID(), $documents, 'ID');
    $items = $result['children'];
}


?>

<section class="bg-frost-50 border-1 border-solid border-frost-300 rounded-2xl p-8 mt-16">
    <h2 class="m-0 text-2xl">
        <?php esc_html_e('Continue', 'documentation') ?>
    </h2>

    <ul class="mt-4 flex flex-col gap-2 list-disc pl-4 font-medium">
        <?php foreach($items as $i => $item): ?>
            <li class="<?php echo esc_attr($item['ID'] === get_the_ID() ? 'list-none' : '') ?>">
                <a 
                    href="<?php echo esc_attr($item['ID'] === get_the_ID() ? '#' : $item['permalink']); ?>" 
                    class="w-full block <?php echo esc_attr($item['ID'] === get_the_ID() ? 'no-underline text-frost-700' : 'underline text-primary hover:no-underline') ?>">
                    <?php echo esc_html($item['title']); ?>         
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
