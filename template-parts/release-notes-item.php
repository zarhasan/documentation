<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
};

?>

<div>
    <div class="flex justify-start items-center gap-4">
        <date class="inline-flex justify-start items-center">
            <span class="w-2 h-2 inline-flex justify-center items-center mr-3 bg-frost-1000 rounded-full"></span>
            <?php echo get_the_date(); ?>
        </date>

        <?php $terms = get_the_terms(get_the_ID(), 'release-note-tags'); ?>

        <?php if ($terms && !is_wp_error($terms)): ?>
            <ul class="flex justify-end items-center gap-2">
                <?php foreach ($terms as $term): ?>
                    <li>
                        <a href="<?php echo esc_url(get_term_link($term)); ?>" class="text-sm font-medium border border-frost-300 border-solid px-3 py-1 rounded-full text-frost-600 hover:underline">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    
    <h2 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-frost-900 sm:text-6xl">
        <?php the_title(); ?>
    </h2>

    <div class="prose">
        <?php the_content(); ?>
    </div>
</div>