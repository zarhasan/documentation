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

<section class="bg-frost-100 py-16 mt-0 border-y border-frost-300">
  <div class="container flex flex-col items-center justify-center gap-4">
    <h1 class="text-5xl font-medium text-frost-900 text-center"><?php esc_html_e('Documentation', 'documentation'); ?></h1>
    <p class="text-base text-frost-700 mt-1 text-center"><?php esc_html_e('Explore our documentation to find the information you need.', 'documentation'); ?></p>

    <button
      x-data="searchTrigger"
      x-on:click="showSearch" 
      x-bind:disabled="isDisabled" 
      class="inline-flex items-center justify-between gap-2 px-4 py-2 text-sm font-semibold text-frost-900 bg-frost-0 border border-frost-300 mt-4 w-full !lg:w-1/2 max-w-full h-12 disabled:opacity-50">
      <p class="text-frost-700"><?php esc_html_e('Search for docs', 'documentation'); ?></p>
      
      <span x-cloak x-show="isNotLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('search'); ?>
      </span>

      <span x-show="isLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('spinner'); ?>
      </span>
    </button>

    <ul class="mt-4 grid gap-4 grid-cols-2">

      <li>
        <a class="flex justify-start items-center flex-col sm:flex-row bg-frost-0 text-frost-1000 border-frost-300 border px-6 py-6 sm:py-4 gap-2 hover:bg-frost-50" href="#" class="#">
          <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo documentation_svg('rocket'); ?></span>
          <span class="font-semibold text-sm"><?php esc_html_e('Getting Started', 'documentation'); ?></span>
          <span class="w-4 h-4 sm:inline-flex justify-center items-center hidden"><?php echo documentation_svg('chevron-right'); ?></span>
        </a>
      </li>

      <li>
        <a class="flex justify-start items-center flex-col sm:flex-row bg-frost-0 text-frost-1000 border-frost-300 border px-6 py-6 sm:py-4 gap-2 hover:bg-frost-50" href="#" class="#">
          <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo documentation_svg('settings'); ?></span>
          <span class="font-semibold text-sm"><?php esc_html_e('Installation', 'documentation'); ?></span>
          <span class="w-4 h-4 sm:inline-flex justify-center items-center hidden"><?php echo documentation_svg('chevron-right'); ?></span>
        </a>
      </li>

      <li>
        <a class="flex justify-start items-center flex-col sm:flex-row bg-frost-0 text-frost-1000 border-frost-300 border px-6 py-6 sm:py-4 gap-2 hover:bg-frost-50" href="#" class="#">
          <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo documentation_svg('code'); ?></span>
          <span class="font-semibold text-sm"><?php esc_html_e('API Reference', 'documentation'); ?></span>
          <span class="w-4 h-4 sm:inline-flex justify-center items-center hidden"><?php echo documentation_svg('chevron-right'); ?></span>
        </a>
      </li>

      <li>
        <a class="flex justify-start items-center flex-col sm:flex-row bg-frost-0 text-frost-1000 border-frost-300 border px-6 py-6 sm:py-4 gap-2 hover:bg-frost-50" href="#" class="#">
          <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo documentation_svg('help-circle'); ?></span>
          <span class="font-semibold text-sm"><?php esc_html_e('Help', 'documentation'); ?></span>
          <span class="w-4 h-4 sm:inline-flex justify-center items-center hidden"><?php echo documentation_svg('chevron-right'); ?></span>
        </a>
      </li>

      
    </ul>

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
