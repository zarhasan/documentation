
<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$toc = documentation_get_toc(get_the_content());

if(!$toc) {
  return;
};

?>

<div dir="rtl" class="documentation_toc col-span-2 h-screen py-10 lg:pl-10 self-start text-left sticky top-0 overflow-y-scroll when-md:hidden">
  <button 
      dir="ltr"
      x-on:click="$store.searchPanel.query = '<?php echo get_the_title(); ?>: '; $store.searchPanel.show(); $dispatch('site-search');" 
      class="w-full flex justify-start items-center gap-2 mb-8 bg-gray-50 rounded-full px-4 py-3 text-start text-sm font-medium border-1 border-gray-300 border-solid">
      <span class="w-4 h-4 inline-flex justify-center items-center shrink-0">
          <?php echo documentation_svg('search'); ?>
      </span>
      <span class="truncate"><?php echo sprintf(__('Search in %s', 'documentation'), get_the_title()); ?></span>
  </button>
  
  <?php echo $toc; ?>

  <a 
    dir="ltr"
    class="inline-flex mt-8 text-sm font-semibold text-primary bg-primary-50 px-4 py-2 border-1 border-primary border-solid rounded-full" href="#header">
    <?php esc_html_e('Back to top', 'documentation'); ?>
  </a>
</div>