<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

<button 
    x-data="searchTrigger"
    x-on:click="showSearch" 
    x-bind:disabled="isDisabled"
    class="lg:max-w-3xl h-12 shrink-0 grow mr-auto text-frost-700 border-b-2 border-frost-1000 border-solid justify-start items-center focus-within:outline-2 focus-within:border-frost-900 when-md:text-sm disabled:opacity-50 hover:bg-gray-50 <?php echo !empty($classes) ? $classes : ''; ?>">
    <span x-cloak x-show="isNotLoading" class="inline-flex justify-center items-center w-5 h-5 mr-4">
        <?php echo documentation_svg('search'); ?>
    </span>

    <span x-show="isLoading" class="inline-flex justify-center items-center w-5 h-5 mr-4">
        <?php echo documentation_svg('spinner'); ?>
    </span>

    <span class="mr-4 text-sm">
        <?php esc_attr_e('Search for docs, posts, pages, etc', 'documentation'); ?>
    </span>
    
    <span class="ml-auto text-xs font-semibold">
        <?php esc_attr_e('Ctrl + K', 'documentation'); ?>
    </span>
</button>