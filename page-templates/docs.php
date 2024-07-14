<?php
/**
 * Template Name: Docs
 *
 */

get_header(); 

$documents = get_document_hierarchy();

$data = [
  'title' => __('RedOxbird Docs', 'documentation'),
  'subtitle' => __('Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.', 'documentation'),
];

$colors = ['teal', 'purple', 'yellow', 'rose', 'indigo', 'pink', 'amber', 'sky', 'emerald', 'fuchsia', 'lime'];

?>

<div class="mt-16">
  <div class="x-container">
    <div class="max-w-2xl lg:mx-0">
      <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
        <?php echo esc_html($data['title']); ?>
      </h2>
      <p class="mt-6 text-lg leading-8 text-gray-600">
        <?php echo esc_html($data['subtitle']); ?>
      </p>

      <div class="mt-8 flex gap-4">
        <a class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-900 px-5 py-3 text-base font-medium text-gray-0 shadow-sm hover:bg-gray-800" href="<?php echo $documents[0]['permalink']; ?>">
          <?php esc_html_e( 'Get started', 'documentation' ); ?>
          <span class="ml-2 -mr-0.5 h-4 w-4">
            <?php echo documentation_svg('arrow-right'); ?>
          </span>
        </a>
      </div>

    </div>
  </div>
</div>

<div class="x-container mt-16"> 
  <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-8">
    <?php foreach ($documents as $index => $document): ?>
      <div x-data="{expanded: false}" class="group relative border-gray-200 border-solid border p-8 bg-gray-0">
        <div>
          <span class="inline-flex rounded-lg bg-<?php echo esc_attr($colors[$index % count($colors)]); ?>-50 p-3 text-<?php echo esc_attr($colors[$index % count($colors)]); ?>-700">
            <?php echo documentation_svg('folder'); ?>
          </span>
        </div>

        <div class="mt-8">
          <h3 class="text-lg font-bold leading-6 text-gray-900">
            <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
              <?php echo esc_html($document['title']); ?>
            </a>
          </h3>

          <ul class="mt-4 text-sm text-gray-700 flex flex-col gap-2">
            <?php foreach ($document['children'] as $index => $children): ?>
                <li 
                    x-bind:class="expanded || '1' == '<?php echo $index < 5 ?>' ? 'block' : 'hidden'">
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
