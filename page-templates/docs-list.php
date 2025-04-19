<?php

get_header(); 

$documents = documentation_get_document_hierarchy();
$theme_options = get_option('documentation_options', documentation_get_default_options());

$colors = ['teal', 'purple', 'yellow', 'rose', 'indigo', 'pink', 'amber', 'sky', 'emerald', 'fuchsia', 'lime'];

$faqs_query = new WP_Query([
  'post_type' => 'faq',
  'posts_per_page' => 10
]);

?>

<section class="bg-frost-100 py-16 mt-0 border-y border-frost-300">
  <div class="x-container flex flex-col items-center justify-center gap-4">
    <h1 class="text-5xl font-medium text-frost-900 text-center">
      <?php echo !empty($theme_options['docs_page_title']) ? esc_html( $theme_options['docs_page_title'] ) : esc_html__('Documentation', 'documentation'); ?>
    </h1>

    <p class="text-base text-frost-700 mt-1 text-center">
      <?php echo !empty($theme_options['docs_page_description']) ? esc_html( $theme_options['docs_page_description'] ) : esc_html__('Explore our documentation to find the information you need.', 'documentation'); ?>
    </p>

    <button
      x-data="fastFuzzySearchTrigger"
      x-on:click="showSearch" 
      x-bind:disabled="isDisabled" 
      data-context="<?php esc_attr_e('Docs', 'documentation'); ?>"
      class="inline-flex items-center justify-between gap-2 px-4 py-2 text-sm font-semibold text-frost-900 bg-frost-0 border border-frost-300 mt-4 w-full !lg:w-1/2 max-w-full h-12 disabled:opacity-50">
      <p class="text-frost-700"><?php esc_html_e('Search for docs...', 'documentation'); ?></p>
      
      <span x-cloak x-show="isNotLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('search'); ?>
      </span>

      <span x-show="isLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo documentation_svg('spinner'); ?>
      </span>
    </button>
  </div>
</section>

<section class="container mt-16"> 
  <div class="grid grid-cols-1 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <?php get_template_part('template-parts/docs-list-card', null, ['document' => $document, 'color' => $color]); ?>
    <?php endforeach; ?>
  </div>
</section>

<div class="container">
  <div class="max-w-4xl mx-auto my-16 sm:my-24">
    <div class="">
        <h2 class="text-4xl text-center tracking-tight text-frost-900 sm:text-5xl">Frequently asked questions</h2>

        <?php if ($faqs_query->have_posts()): ?>
            <dl 
                class="relative mt-8 sm:mt-16 block space-y-6 divide-y divide-frost-900/10 bg-frost-0 border-frost-300 border-solid border pt-4 px-8 pb-8"
                x-data="faq" 
                x-on:keydown.window="handleWindowEscape">

                <?php $activeIndex = 0; ?>

                <?php while ($faqs_query->have_posts()): $faqs_query->the_post(); ?>                
                    <div
                        data-active-index="<?php echo esc_attr($activeIndex); ?>"
                        class="pt-6">
                        <dt>
                            <button 
                                type="button" 
                                class="flex w-full items-start justify-between text-left text-frost-900 transition hover:bg-frost-50" 
                                x-bind:aria-expanded="isActive" 
                                aria-controls="faq-content-<?php echo esc_attr($activeIndex); ?>" 
                                id="faq-header-<?php echo esc_attr($activeIndex); ?>" 
                                x-on:click="handleClick">
                                <span class="text-base/7 font-bold">
                                    <?php echo get_the_title(); ?>
                                </span>

                                <span 
                                    x-cloak
                                    x-show="isNotActive" 
                                    class="ml-6 flex h-7 items-center shrink-0">
                                    <?php echo documentation_svg('chevron-down'); ?>
                                </span>

                                <span 
                                    x-cloak
                                    x-show="isActive" 
                                    class="ml-6 flex h-7 items-center shrink-0">
                                    <?php echo documentation_svg('chevron-up'); ?>
                                </span>

                            </button>
                        </dt>

                        <dd 
                            class="mt-2 pr-12 prose" 
                            x-show="isActive" 
                            role="region" 
                            id="faq-content-<?php echo esc_attr($activeIndex); ?>" 
                            aria-labelledby="faq-header-<?php echo esc_attr($activeIndex); ?>" 
                            style="display: none;"
                            x-collapse>
                            <?php echo get_the_content(); ?>
                        </dd>
                    </div>

                    <?php $activeIndex++; ?>
                <?php endwhile; ?>
            </dl>
        <?php else: ?>
        
        <?php 
            get_template_part('template-parts/empty-state', null, [
                'title' => __('No FAQs', 'documentation'),
                'description' => __('It seems that no FAQs have been created yet.', 'documentation'),
                'icon' => 'notes-off',
            ]);
        ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
get_footer();
