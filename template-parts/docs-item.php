<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div 
    class="w-full border-1 border-gray-300 border-dashed p-10 rounded-xl" 
    id="post-<?php echo esc_attr($document['ID']); ?>">

    <div class="w-full h-full flex justify-start items-stretch flex-wrap">
        <div class="w-full pt-8 lg:pt-0 lg:w-3/5 grow">
            <h3 class="text-2xl m-0 mt-1 w-full font-primary">
                <a class="hover:underline hover:text-primary-darker" href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark">
                    <?php echo esc_html($document['title']); ?>
                </a>
            </h3>
      
            <div class="mt-3">
                <?php echo get_the_excerpt($document['ID']); ?>
            </div>


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
        </div>
    </div>
</div><!-- #post-## -->