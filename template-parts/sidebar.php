<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$documents = get_document_hierarchy();

?>

<ul>
  <?php foreach ($documents as $index => $document): ?>
    <li>
      <a href="<?php echo esc_attr($document['permalink']); ?>">
        <?php echo esc_html($document['title']); ?>
      </a>

        <ul>
          <?php foreach ($document['headings'] as $index => $heading): ?>
            <li>
              <a href="#<?php echo sanitize_title($heading); ?>">
                <?php echo esc_html($heading); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
    </li>
  <?php endforeach; ?>
</ul>