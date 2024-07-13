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
    <div class="mx-auto max-w-2xl lg:mx-0">
      <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Support center</h2>
      <p class="mt-6 text-lg leading-8 text-gray-600">
        <?php echo wp_kses_post($data['subtitle']); ?>
      </p>
    </div>
  </div>
</div>

<div class="x-container mt-16"> 
  <div class="sm:grid sm:grid-cols-3 gap-16">
    <?php foreach ($documents as $index => $document): ?>
      <div class="group relative">
        <div>
          <span class="inline-flex rounded-lg bg-<?php echo esc_attr($colors[$index]); ?>-50 p-3 text-<?php echo esc_attr($colors[$index]); ?>-700">
            <?php echo documentation_svg('folder'); ?>
          </span>
        </div>

        <div class="mt-8">
          <h3 class="text-lg font-bold leading-6 text-gray-900">
            <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
              <!-- Extend touch target to entire panel -->
              <?php echo esc_html($document['title']); ?>
            </a>
          </h3>

          <ul class="mt-4 text-sm text-gray-700 flex flex-col gap-2 list-disc pl-4">
            <?php foreach (array_slice($document['children'], 0, 5) as $index => $children): ?>
                <li>
                    <a class="w-full block hover:underline" href="<?php echo esc_attr($children['permalink']); ?>">
                      <?php echo esc_html($children['title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
          </ul>
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
