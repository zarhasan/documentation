<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header();

$posts_page_id = get_option('page_for_posts');
$posts_page_url = get_the_permalink($posts_page_id);

$categories = get_categories([
    'type' => 'post',
    'child_of' => 0,
    'orderby' => 'count',
    'order' => 'DESC',
    'hide_empty' => 1,
    'hierarchical' => 1,
    'parent' => 0,
    'exclude' => get_cat_ID('uncategorized'),
    'number' => 10
]);

if (is_category()) {
   $current_category = get_queried_object();
}

?>

<div id="primary" class="content-area grid lg:grid-cols-12 x-container">
	<?php $card_type = get_theme_mod('blog_card_type', 'default'); ?>

    <div class="col-span-12 flex-grow self-stretch mb-16 mt-8">
        <?php
            $archive_title = 'Archive';
            if (is_category()) {
                $archive_title = get_the_archive_title();
            } elseif (is_tag()) {
                $archive_title = get_the_archive_title();
            } elseif (is_author()) {
                $archive_title = get_the_archive_title();
            } elseif (is_date()) {
                $archive_title = get_the_archive_title();
            } elseif (is_post_type_archive()) {
                $archive_title = post_type_archive_title('', false);
            } elseif (is_tax()) {
                $archive_title = single_term_title('', false);
            } else if(is_home()) {
                $archive_title = __('Blog Posts', 'documentation');
            } else {
                $archive_title = 'Archive';
            }
        ?>

        <h1>
			<?php echo wp_kses_post($archive_title); ?>
        </h1>

        <div class="flex justify-start items-center flex-wrap w-full gap-4 mt-8 whitespace-nowrap bg-gray-0 border border-gray-200 p-2">
            <a 
                class="text-sm current:bg-gray-1000 current:text-gray-0 px-4 py-2" 
                href="<?php echo esc_url($posts_page_id ? $posts_page_url : home_url()); ?>"
                <?php if(!is_category()): ?>
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

        <?php if (have_posts()): ?>
            <div class="w-full grid 2xl:grid-cols-3 lg:grid-cols-2 gap-12 my-12">
                <?php 
                    global $wp_query;

                    while (have_posts()): the_post();

                    get_template_part('template-parts/post-card', $card_type.get_post_format());

                    endwhile;
                ?>
            </div>
        <?php else: ?>
            <?php get_template_part('template-parts/content/none'); ?>

        <?php endif; ?>

        <?php 
            if($wp_query->max_num_pages > 1) {
                get_template_part('template-parts/pagination'); 
            }
        ?>
    </div>

</div><!-- #primary -->


<?php
get_footer();