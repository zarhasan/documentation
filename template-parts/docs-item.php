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
        <div class="w-full pt-8 lg:pt-0 lg:w-3/5 grow">
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
        </div>
    </div>
</div><!-- #post-## -->