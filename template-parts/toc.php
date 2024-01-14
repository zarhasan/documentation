
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

<div class="documentation_toc col-span-3 h-screen p-10 self-start sticky top-0 overflow-y-scroll when-sm:hidden">
  <?php echo $toc; ?>
</div>