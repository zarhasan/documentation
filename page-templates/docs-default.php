<?php
/**
 * Template Name: Docs (Default)
 *
 */

get_header(); 

$documents = documentation_get_document_hierarchy();
$theme_options = get_option('documentation');

$colors = ['teal', 'purple', 'yellow', 'rose', 'indigo', 'pink', 'amber', 'sky', 'emerald', 'fuchsia', 'lime'];
?>

<section class="bg-gray-100 py-16 mt-0 border-y border-gray-300">
  <div class="container flex flex-col items-center justify-center gap-4">
    <h1 class="text-5xl font-medium text-frost-900"><?php esc_html_e('Documentation', 'documentation'); ?></h1>
    <p class="text-base text-frost-700 mt-1"><?php esc_html_e('Explore our documentation to find the information you need.', 'documentation'); ?></p>

    <button
      x-data="searchTrigger"
      x-on:click="showSearch" 
      x-bind:disabled="isDisabled" 
      class="inline-flex items-center justify-between gap-2 px-4 py-2 text-sm font-semibold text-frost-900 bg-frost-50 border border-frost-300 mt-4 w-auto !lg:w-1/2 max-w-full h-12 disabled:opacity-50">
      <p class="text-gray-700"><?php esc_html_e('Search for docs', 'documentation'); ?></p>
      
      <span x-cloak x-show="isNotLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('search'); ?>
      </span>

      <span x-show="isLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('spinner'); ?>
      </span>
    </button>

  </div>
</section>

<div class="x-container mt-16"> 
  <div class="grid sm:grid-cols-3 xl:grid-cols-3 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <?php get_template_part('template-parts/docs-card', null, ['document' => $document, 'color' => $color]); ?>
    <?php endforeach; ?>
  </div>
</div>

<?php
get_footer();
