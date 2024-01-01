<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<article class="relative group">
    <div class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-gray-100"></div>

    <svg viewBox="0 0 9 9"
       class="hidden absolute right-full mr-6 top-2 text-primary md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block">
       <circle cx="4.5"
            cy="4.5"
            r="4.5"
            stroke="currentColor"
            class="fill-white"
            stroke-width="2">
        </circle>
    </svg>

    <div class="relative">
        <h3 class="text-base font-semibold tracking-tight text-gray-900 pt-8 lg:pt-0">
            <?php echo esc_html(get_the_title()); ?>
        </h3>
        <div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
            <p><?php the_excerpt(); ?></p>
        </div>
        <dl class="absolute left-0 top-0 lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
            <dt class="sr-only">Date</dt>
            <dd class="whitespace-nowrap text-sm leading-6 text-gray-600"><time datetime="2023-12-20T20:00:00.000Z"><?php echo get_the_date('F j, Y'); ?></time></dd>
        </dl>
    </div>
  
    <a class="flex items-center text-sm text-primary font-medium" href="<?php the_permalink(); ?>">
        <span
          class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span><span
          class="relative">
          Read more
          <span class="sr-only">, <?php the_title(); ?></span>
        </span>

        <svg class="relative mt-px overflow-visible ml-2.5 text-sky-300 dark:text-sky-700"
         width="3"
         height="6"
         viewBox="0 0 3 6"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
            <path d="M0 0L3 3L0 6"></path>
        </svg>
    </a>
</article>

