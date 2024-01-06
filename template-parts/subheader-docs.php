<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div class="px-10 h-16 border-b-1 border-gray-300 border-solid w-full flex justify-start items-center">
  <div class="documentation_breadcrumb">
    <?php echo documentation_get_breadcrumb(); ?>
  </div>
</div>