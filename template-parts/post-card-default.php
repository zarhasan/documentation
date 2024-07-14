<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$headings = documentation_get_level_2_headings(get_the_content());
$author_id = get_the_author_meta('ID');

?>

<article class="relative group border border-gray-200 bg-gray-0 p-6 flex flex-col overflow-hidden">
    <?php if(has_post_thumbnail()): ?>
        <a href="<?php the_permalink(); ?>" class="block w-full h-44 rounded overflow-hidden mb-6 border-gray-300 border-1 border-solid">
            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
        </a>
    <?php endif; ?>

    <div class="flex flex-col grow gap-2">
        <a href="<?php the_permalink(); ?>" class="block text-xs text-gray-700">
            <span class="sr-only"><?php esc_html_e('Posted on: ', 'documentation'); ?></span>
            <?php echo date_i18n('F jS, Y', strtotime(get_the_date())); ?>
        </a>            

        <h2 class="text-2xl font-bold mt-4">
            <a class="block text-gray-800 hover:underline" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        
        <div><?php the_excerpt(); ?></div>

        <ul class="list-disc mt-4 pl-4 space-y-2 mb-4">
            <?php foreach($headings as $index => $heading): ?>
                <li>
                    <a class="text-sm font-medium underline hover:no-underline" href="<?php the_permalink(); ?>#<?php echo sanitize_title($heading); ?>">
                        <?php echo esc_html($heading); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="flex justify-between items-center gap-2 pt-6 mt-auto font-medium border-t-2 border-gray-900">
            <span class="w-8 h-8 rounded-full overflow-hidden">
                <?php echo get_avatar($author_id, 100); ?>
            </span>

            <a class="text-sm" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                <?php the_author(); ?>
            </a>
        </div>
    </div>

    
</article>

