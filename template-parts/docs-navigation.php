<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$prev_link = get_previous_post_link('%link');
$next_link = get_next_post_link('%link');

?>

<div class="list-none m-0 p-0 flex justify-between items-center flex-wrap lg:flex-nowrap gap-4 bg-background-900 my-4 mt-8 w-full">
    <?php if($next_link): ?>
        <div class="w-full lg:w-1/2 lg:flex-grow bg-primary-50 text-primary border-1 border-primary-300 border-solid rounded-xl p-6 self-stretch transition-all ease-out-expo hover:bg-primary-100">
            <p class="flex justify-start items-center font-sm mb-1 gap-2">
                <span class="w-4 h-auto flex justify-start item-center">
                    <?php echo documentation_svg('arrow-left'); ?>
                </span>

                <?php esc_html_e('Next', 'documentation'); ?>

            </p>
            <span class="text-underline font-semibold hover:underline">
                <?php next_post_link('%link'); ?>            
            </span>
        </div>
    <?php endif; ?>

    <?php if($prev_link): ?>
        <div class="w-full lg:w-1/2 lg:flex-grow bg-primary-50 text-primary border-1 border-primary-300 border-solid rounded-xl p-6 self-stretch transition-all ease-out-expo hover:bg-primary-100 text-right">
            <p class="flex justify-end items-center font-sm mb-1 gap-2">
                <?php esc_html_e('Previous', 'documentation'); ?>

                <span class="w-4 h-auto flex justify-end item-center">
                    <?php echo documentation_svg('arrow-right'); ?>
                </span> 
            </p>
            <span class="text-underline font-semibold hover:underline">
                <?php echo previous_post_link('%link'); ?>
            </span>
        </div>
    <?php endif; ?>
</div>
