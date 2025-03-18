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
    <div class="">
        <h2 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Frequently asked questions</h2>
      
        <div class="flex justify-start items-center flex-wrap w-full gap-4 mt-8 mb-8 whitespace-nowrap bg-gray-0 border border-gray-200 p-2">
            <a 
                class="text-sm current:bg-gray-1000 current:text-gray-0 px-4 py-2 hover:bg-gray-50" 
                href="<?php echo esc_url(get_post_type_archive_link('faq')); ?>"
                <?php if(!is_tax('faq_category')): ?>
                    aria-current="page"
                <?php endif; ?>>
                <?php esc_html_e('All', 'documentation') ?>
            </a>

            <?php if(!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a 
                        class="text-sm current:bg-gray-1000 current:text-gray-0 px-4 py-2 hover:bg-gray-50" 
                        href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                        <?php if(!empty($current_category) && $current_category->term_id == $category->term_id): ?>
                            aria-current="page"
                        <?php endif; ?>
                        >
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($query->have_posts()): ?>
            <dl 
                class="relative mt-8 block space-y-6 divide-y divide-gray-900/10"
                x-data="faq" 
                x-on:keydown.window="handleWindowEscape">

                <?php $activeIndex = 0; ?>

                <?php while ($query->have_posts()): $query->the_post(); ?>                
                    <div
                        data-active-index="<?php echo esc_attr($activeIndex); ?>"
                        class="pt-6">
                        <dt
                            >
                            <button 
                                type="button" 
                                class="flex w-full items-start justify-between text-left text-gray-900 transition hover:bg-gray-50" 
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
                                    class="ml-6 flex h-7 items-center">
                                    <?php echo documentation_svg('chevron-down'); ?>
                                </span>

                                <span 
                                    x-cloak
                                    x-show="isActive" 
                                    class="ml-6 flex h-7 items-center">
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
