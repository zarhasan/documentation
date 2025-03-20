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
    class="w-6 h-6 inline-flex justify-center items-center text-frost-600 <?php echo !empty($classes) ? $classes : ''; ?>">
    <span x-cloak x-show="isNotLoading" class="inline-flex justify-center items-center">
        <?php echo documentation_svg('search'); ?>
    </span>

    <span x-show="isLoading" class="inline-flex justify-center items-center">
        <?php echo documentation_svg('spinner'); ?>
    </span>
</button>