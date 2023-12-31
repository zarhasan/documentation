<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div 
    class="w-full border-b-1 border-gray-200 pb-12 last-child:border-b-0" 
    id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

    <div class="w-full h-full flex justify-start items-stretch flex-wrap">
        <?php if(has_post_thumbnail()): ?>
            <a class="group w-full lg:w-2/5 block shrink-0 bg-gray-100" href="<?php echo esc_attr( get_the_permalink() ); ?>">
                <?php get_template_part('template-parts/post', 'image');?>
            </a>
        <?php endif; ?>

        <div class="w-full pt-8 lg:pt-0 lg:w-3/5 grow lg:pl-12">
            <h2 class="text-4xl m-0 mt-1 w-full font-body font-semibold">
                <a class="hover:underline hover:text-primary-darker" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                    <?php echo esc_html(get_the_title()); ?>
                </a>
            </h2>
            
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <p class="text-base mt-4">
                    <?php echo get_the_date('F j, Y'); ?>
                </p>
            </a>

            <div class="mt-3">
                <?php the_excerpt(); ?>
            </div>

            <!-- 
            <a class="mt-auto font-semibold text-primary-darker underline" href="<?php the_permalink() ?>">
                Read More <span class="sr-only">(<?php the_title(); ?>)</span>
            </a> -->
        </div>
    </div>
</div><!-- #post-## -->