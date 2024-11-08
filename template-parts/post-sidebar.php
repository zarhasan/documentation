<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$current_post_id = get_the_ID();
$current_post_date = get_the_date('Y-m-d H:i:s', $current_post_id);

$latest_posts = new WP_Query([
    'post_type' => get_post_type(),
    'posts_per_page' => 12,
    'order' => 'DESC',
    'orderby' => 'date',
    'ignore_sticky_posts' => 1,
    'date_query'     => array(
        array(
            'before'    => $current_post_date,
            'inclusive' => true,
        ),
    )
]);

?>

<div data-simplebar class="!sticky top-0 sm:w-72 shrink-0 border-gray-300 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start when-md:hidden">
    <?php if ($latest_posts->have_posts()) : ?>
        <ul class="text-sm flex flex-col gap-3">
            <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
            <li class="flex flex-col gap-1">
                <a class="inline-flex justify-start items-center <?php echo $current_post_id === get_the_ID() ? 'font-bold underline' : ''; ?>" href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</div>