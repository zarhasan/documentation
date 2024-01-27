<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div 
    x-data
    class="relative w-full border-1 border-gray-300 border-solid p-10 rounded-xl bg-gray-0 shadow-sm z-10" 
    id="post-<?php echo esc_attr($document['ID']); ?>">

    <div class="w-full h-full flex justify-start items-stretch flex-wrap">
        <div class="w-full pt-8 lg:pt-0 lg:w-3/5 grow">
            <span class="w-8 h-8 inline-flex justify-center items-center mb-4">
                <?php echo documentation_svg('folder'); ?>
            </span>

            
            <h3 class="text-xl m-0 mt-1 w-full font-primary font-semibold">
                <a class="hover:underline hover:text-primary-darker" href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark">
                    <?php echo esc_html($document['title']); ?>
                </a>
            </h3>
            
            <p class="text-sm text-gray-700 mt-2">
                <?php echo get_the_date(); ?>
            </p>
      
            <ul class="mt-4 flex flex-col gap-2 underline list-disc pl-4 font-medium">
                <?php foreach ($document['children'] as $index => $children): ?>
                    <li>
                        <a 
                        class="w-full block text-primary" 
                        href="<?php echo esc_attr($children['permalink']); ?>">
                        <?php echo esc_html($children['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <button x-on:click="$store.searchPanel.show()" class="w-full flex justify-start items-center gap-2 mt-8 bg-gray-50 rounded-full px-4 py-3 text-start text-sm font-medium border-1 border-gray-300 border-solid">
                <span class="w-4 h-4 inline-flex justify-center items-center shrink-0">
                    <?php echo documentation_svg('search'); ?>
                </span>
                <?php echo sprintf(__('Search in %s', 'documentation'), $document['title']); ?>
            </button>
        </div>
    </div>
</div><!-- #post-## -->