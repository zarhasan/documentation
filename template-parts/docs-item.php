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
    class="relative w-full bg-frost-0 z-10" 
    id="post-<?php echo esc_attr($document['ID']); ?>">

    <div class="w-full h-full flex justify-start items-stretch flex-wrap">
        <div class="w-full lg:pt-0 lg:w-3/5 grow">
            <span class="w-8 h-8 inline-flex justify-center items-center mb-4">
                <?php echo documentation_svg('folder'); ?>
            </span>

            
            <h3 class="text-2xl m-0 mt-1 w-full font-primary">
                <a class="hover:underline hover:text-frost-1000" href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark">
                    <?php echo esc_html($document['title']); ?>
                </a>
            </h3>
            
            <ul class="mt-4 flex flex-col gap-2 list-disc pl-4 font-medium">
                <?php foreach (array_slice($document['children'], 0, 5) as $index => $children): ?>
                    <li>
                        <a class="w-full block hover:underline" href="<?php echo esc_attr($children['permalink']); ?>">
                            <?php echo esc_html($children['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div><!-- #post-## -->