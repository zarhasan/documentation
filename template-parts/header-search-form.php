<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

    <form 
        class="search-form flex justify-end items-center bg-primary-100 rounded-full w-full" 
        role="search" 
        method="get" 
        action="<?php echo esc_url(home_url('/')); ?>">
        
        <label class="inline-flex group relative m-0 w-full" x-bind:class="[focused ? 'focused' : '']">
            <span class="block text-gray-900 text-base mb-1 font-normal pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 transition-all duration-500 ease-out-expo focused:(-translate-x-3 -translate-y-11 scale-75 font-semibold text-gray-900)">
                <?php echo esc_html__('Search', 'documentation'); ?>
            </span>
            <input 
                x-ref="input"
                type="search" 
                class="search-field bg-transparent border-none outline-none rounded-full grow" 
                value="<?php echo get_search_query(); ?>" 
                name="s" 
            />

            <div 
                x-cloak
                x-show="results.length > 0"
                x-transition:enter="xyz-in"
                xyz="fade down-1 duration-2" 
                class="absolute w-72 left-0 top-full mt-2 bg-white border-1 border-gray-900 p-6 rounded-xl">
                <ul class="flex flex-col gap-4">
                    <template x-for="(result, i) in results">
                        <li>
                            <a class="hover:underline" x-bind:href="result.permalink">
                                <p class="font-semibold" x-text="result.title"></p>
                                <p x-text="result.excerpt"></p>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </label>

        <button type="submit" class="search-submit h-10 w-10 p-3 flex justify-center items-center text-gray-900">
            <span x-show="state === 'searched' || state === 'idle'">
                <?php echo documentation_svg('search'); ?>
            </span>
            <span x-show="state === 'searching'">
                <?php echo documentation_svg('spinner'); ?>
            </span>
        </button>
    </form>
