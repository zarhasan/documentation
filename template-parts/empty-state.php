<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>


<main class="grid min-h-full place-items-center x-container py-32">
    <div class="text-center">
        <div class="flex justify-center items-center">
            <?php echo documentation_svg(!empty($icon) ? $icon : 'notes-off', 'w-16 h-16 stroke-1 text-frost-400 mb-4'); ?>
        </div>
        <h1 class="mt-4 text-balance text-3xl font-semibold tracking-tight text-frost-900">
            <?php echo esc_html($title); ?>
        </h1>
        <p class="mt-6 text-pretty text-base font-medium text-frost-500 sm:text-xl/8">
            <?php echo esc_html($description); ?>
        </p>
    </div>
</main>