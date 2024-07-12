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
]

?>

<div class="mt-16">
  <div class="container">
    <div class="mx-auto max-w-2xl lg:mx-0">
      <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Support center</h2>
      <p class="mt-6 text-lg leading-8 text-gray-600">
        <?php echo wp_kses_post($data['subtitle']); ?>
      </p>
    </div>
  </div>
</div>


<div class="w-full mt-16">
  <div class="container mx-auto grid lg:grid-cols-3 gap-16">
    <?php foreach ($documents as $index => $document): ?>
      <div class="mt-3">
        <?php get_template_part('template-parts/docs-item', null, ['document' => $document]); ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
get_footer();
