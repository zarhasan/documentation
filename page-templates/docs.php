<?php
/**
 * Template Name: Docs
 *
 */

get_header(); 

$documents = documentation_get_document_hierarchy();
$theme_options = get_option('documentation');

$colors = ['teal', 'purple', 'yellow', 'rose', 'indigo', 'pink', 'amber', 'sky', 'emerald', 'fuchsia', 'lime'];

?>

<div class="x-container mt-16"> 
  <div class="grid sm:grid-cols-3 xl:grid-cols-3 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <div x-data="{expanded: false}" class="group relative border-gray-200 border-solid border p-8 bg-gray-0">
        <div>
          <span class="inline-flex rounded-lg p-3 border border-solid bg-<?php echo esc_attr($color); ?>-50 text-<?php echo esc_attr($color); ?>-700 border-<?php echo esc_attr($color); ?>-700">
            <?php echo documentation_svg('folder'); ?>
          </span>
        </div>

        <div class="mt-8">
          <h3 class="text-lg font-bold leading-6 text-gray-900">
            <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
              <?php echo esc_html($document['title']); ?>
            </a>
          </h3>

          <ul class="mt-4 text-base text-gray-700 flex flex-col gap-2">
            <?php foreach ($document['children'] as $index => $children): ?>
              <li 
                x-bind:class="expanded || '1' == '<?php echo esc_attr($index < 5) ?>' ? 'block' : 'hidden'">
                <a class="w-full inline-flex justify-start items-center hover:underline" href="<?php echo esc_attr($children['permalink']); ?>">
                  <span class="w-4 h-4 inline-flex justify-center items-center mr-2">
                    <?php echo documentation_svg('clipboard-text'); ?>
                  </span>
                  <?php echo esc_html($children['title']); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>

          <?php if (!empty($document['children']) && count($document['children']) > 5): ?>
            <button class="inline-flex items-center justify-center mt-4 w-6 h-6 text-gray-600" x-on:click="expanded = !expanded">
              <span x-show="!expanded" aria-hidden="true"><?php echo documentation_svg('chevron-down'); ?></span>
              <span x-cloak x-show="expanded" aria-hidden="true"><?php echo documentation_svg('chevron-up'); ?></span>
            </button>
          <?php endif; ?>
        </div>
      
        <span class="pointer-events-none absolute right-6 top-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
          </svg>
        </span>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
get_footer();
