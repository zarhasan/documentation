
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

<div dir="rtl" class="documentation_toc col-span-2 h-screen py-10 pl-10 self-start text-left sticky top-0 overflow-y-scroll when-sm:hidden">
  <?php echo $toc; ?>

  <a class="inline-flex mt-8 text-sm font-semibold text-primary bg-primary-50 px-4 py-2 border-1 border-primary border-solid rounded-full" href="#header">
    <?php esc_html_e('Back to top', 'documentation'); ?>
  </a>
</div>