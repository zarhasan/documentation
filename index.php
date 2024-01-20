<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header();

$posts_page_id = get_option('page_for_posts');
$posts_page_url = get_permalink($posts_page_id);

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

<?php get_template_part('template-parts/subheader'); ?>

<div id="primary" class="content-area">
	<?php $card_type = get_theme_mod('blog_card_type', 'default'); ?>

    <div class="px-10 flex-grow self-stretch mb-16 mt-8">
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
                $archive_title = __('Blog');
            } else {
                $archive_title = 'Archive';
            }
        ?>

        <h1>
			<?php echo wp_kses_post($archive_title); ?>
        </h1>

        <div class="flex justify-start items-center flex-wrap gap-2 mt-8 when-sm:flex-wrap">
            <a class="px-6 py-3 rounded-full border-1 border-solid border-gray-300 current:bg-gray-700 current:text-white" href="<?php echo esc_url($posts_page_url); ?>">
                <?php esc_html_e('All', 'wpresidence') ?>
            </a>

            <?php if(!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a 
                        class="px-6 py-3 rounded-full border-1 border-solid border-gray-300 current:bg-primary-50 current:text-primary current:border-primary" 
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
            <div class="w-full grid lg:grid-cols-4 gap-12 my-12">
                <?php 
                    global $wp_query;

                    while (have_posts()): the_post();

                    get_template_part('template-parts/post-card', $card_type.get_post_format());

                    endwhile;
                ?>
            </div>
        <?php else: ?>
            <?php get_template_part( 'template-parts/content/none'); ?>

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