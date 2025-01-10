<?php
/**
 * Template Name: FAQs
 *
 */

get_header(); 

global $wp_query;

$query = new WP_Query([
    'post_type' => 'faq',
    'posts_per_page' => -1
]);

$categories = get_terms([
    'taxonomy' => 'faq_category',
    'hide_empty' => false,
    'parent' => 0,
    'number' => 10,
    'orderby' => 'count',
    'order' => 'DESC',
    'exclude' => get_cat_ID('uncategorized'),
    'hierarchical' => true,
]);

if (is_tax('faq_category')) {
    $current_category = get_queried_object();
    $query = $wp_query;
}

?>

<div class="">
  <div class="x-container my-16">
    <div class="mx-auto max-w-4xl">
      <h2 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Frequently asked questions</h2>
      
      <div class="flex justify-start items-center flex-wrap w-full gap-4 mt-8 mb-8 whitespace-nowrap bg-gray-0 border border-gray-200 p-2">
        <a 
            class="text-sm current:bg-gray-1000 current:text-gray-0 px-4 py-2" 
            href="<?php echo esc_url(get_post_type_archive_link('faq')); ?>"
            <?php if(!is_tax('faq_category')): ?>
                aria-current="page"
            <?php endif; ?>>
            <?php esc_html_e('All', 'documentation') ?>
        </a>

        <?php if(!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <a 
                    class="text-sm current:bg-gray-1000 current:text-gray-0 px-4 py-2" 
                    href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                    <?php if(!empty($current_category) && $current_category->term_id == $category->term_id): ?>
                        aria-current="page"
                    <?php endif; ?>
                    >
                    <?php echo $category->name; ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

      <?php if ($query->have_posts()): ?>
        <dl 
            class="relative mt-8 block space-y-6 divide-y divide-gray-900/10"
            x-data="{ activeIndex: null }" 
            x-on:keydown.window="
            $event.key === 'ArrowDown' && (activeIndex = (activeIndex + 1) % 3);
            $event.key === 'ArrowUp' && (activeIndex = (activeIndex + 3 - 1) % 3)">

            <?php $activeIndex = 0; ?>

            <?php while ($query->have_posts()): $query->the_post(); ?>                
                <div class="pt-6">
                    <dt>
                        <button 
                            type="button" 
                            class="flex w-full items-start justify-between text-left text-gray-900 transition hover:bg-gray-50" 
                            x-bind:aria-expanded="activeIndex === <?php echo $activeIndex; ?>" 
                            x-bind:aria-controls="'faq-content-' + <?php echo $activeIndex; ?>" 
                            id="faq-header-<?php echo $activeIndex; ?>" 
                            x-on:click="activeIndex = activeIndex === <?php echo $activeIndex; ?> ? null : <?php echo $activeIndex; ?>">
                            <span class="text-base/7 font-bold">
                                <?php echo get_the_title(); ?>
                            </span>

                            <span 
                                x-cloak
                                x-show="activeIndex !== <?php echo $activeIndex; ?>" 
                                class="ml-6 flex h-7 items-center">
                                <?php echo documentation_svg('chevron-down'); ?>
                            </span>

                            <span 
                                x-cloak
                                x-show="activeIndex === <?php echo $activeIndex; ?>" 
                                class="ml-6 flex h-7 items-center">
                                <?php echo documentation_svg('chevron-up'); ?>
                            </span>

                        </button>
                    </dt>

                    <dd 
                        class="mt-2 pr-12 prose" 
                        x-show="activeIndex === <?php echo $activeIndex; ?>" 
                        role="region" 
                        x-bind:id="'faq-content-' + <?php echo $activeIndex; ?>" 
                        x-bind:aria-labelledby="'faq-header-' + <?php echo $activeIndex; ?>" 
                        style="display: none;"
                        x-collapse>
                        <?php echo get_the_content(); ?>
                    </dd>
                </div>

                <?php $activeIndex++; ?>
            <?php endwhile; ?>
        </dl>
      <?php else: ?>
        <p>No FAQs found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
get_footer();
