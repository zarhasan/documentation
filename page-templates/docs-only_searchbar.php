<?php

get_header(); 

$documents = documentation_get_document_hierarchy();
$theme_options = get_option('documentation_options', documentation_get_default_options());
?>

<section class="py-40 mt-0">
  <div class="x-container flex flex-col items-center justify-center gap-4">
    <h1 class="text-5xl font-medium text-frost-900 text-center">
      <?php echo !empty($theme_options['docs_page_title']) ? esc_html( $theme_options['docs_page_title'] ) : esc_html__('Documentation', 'documentation'); ?>
    </h1>

    <p class="text-base text-frost-700 mt-1 text-center">
      <?php echo !empty($theme_options['docs_page_description']) ? esc_html( $theme_options['docs_page_description'] ) : esc_html__('Explore our documentation to find the information you need.', 'documentation'); ?>
    </p>

    <button
      x-data="fastFuzzySearchTrigger"
      x-on:click="showSearch" 
      x-bind:disabled="isDisabled" 
      data-context="<?php esc_attr_e('Docs', 'documentation'); ?>"
      class="inline-flex items-center justify-between gap-2 px-4 py-2 text-sm font-semibold text-frost-900 bg-frost-0 border border-frost-300 mt-8 w-full !lg:w-1/3 max-w-full h-12 disabled:opacity-50">
      <p class="text-frost-700"><?php esc_html_e('Search for docs...', 'documentation'); ?></p>
      
      <span x-cloak x-show="isNotLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('search'); ?>
      </span>

      <span x-show="isLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('spinner'); ?>
      </span>
    </button>
  </div>
</section>


<?php
get_footer();
