
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

<div data-simplebar class="documentation_toc w-72 h-screen py-8 lg:pl-10 self-start text-left !sticky top-0 overflow-y-scroll hidden xl:block">
  
  <?php echo $toc; ?>

  <a 
    class="inline-flex mt-8 text-sm font-semibold justify-center items-center whitespace-nowrap" href="#header">
    <?php esc_html_e('Back to top', 'documentation'); ?>
    <span class="inline-block ml-2 w-4 h-4"><?php echo documentation_svg('arrow-up'); ?></span>
  </a>
</div>