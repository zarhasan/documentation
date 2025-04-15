
<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if(!$toc) {
  return;
};

?>

<div 
  data-simplebar 
  class="documentation_toc w-72 h-screen py-8 lg:pl-10 self-start text-left !sticky top-0 overflow-y-scroll hidden xl:block">
  
  <button
    x-data="fastFuzzySearchTrigger"
    x-on:click="showSearch" 
    x-bind:disabled="isDisabled" 
    data-context="<?php the_title(); ?>"
    class="inline-flex items-center justify-between gap-2 px-4 py-2 text-sm font-semibold text-frost-900 bg-frost-0 border border-frost-300 mb-8 w-full max-w-full h-10 disabled:opacity-50">
    <p class="text-frost-700"><?php esc_html_e('Search in this page', 'documentation'); ?></p>
    
    <span x-cloak x-show="isNotLoading" class="w-4 h-4 inline-flex justify-center items-center">
      <?php echo documentation_svg('search'); ?>
    </span>

    <span x-show="isLoading" class="w-4 h-4 inline-flex justify-center items-center">
      <?php echo documentation_svg('spinner'); ?>
    </span>
  </button>
  
  <?php echo wp_kses_post($toc); ?>

  <a 
    class="inline-flex mt-8 text-sm font-semibold justify-center items-center whitespace-nowrap" href="#header">
    <?php esc_html_e('Back to top', 'documentation'); ?>
    <span class="inline-block ml-2 w-4 h-4"><?php echo documentation_svg('arrow-up'); ?></span>
  </a>
</div>