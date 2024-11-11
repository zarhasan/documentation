<?php
/**
 * Template Name: Release Notes
 *
 */

get_header();

$term = get_queried_object();

$args = [
    'post_type' => 'release-note',
    'posts_per_page' => -1,
];

if(is_tax()) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'release-note-tags',
            'field'    => 'slug',
            'terms'    => $term->slug,
        ),
    );
};

$wp_query = new WP_Query($args);

?>

<?php if($wp_query->have_posts()): ?>
    <section class="x-container !sm:max-w-4xl mx-auto py-16 flex flex-col gap-12">
        <?php while ($wp_query->have_posts()): $wp_query->the_post(); ?>
            <div>
                <div class="flex justify-start items-center gap-4">
                    <date class="inline-flex justify-start items-center">
                        <span class="w-2 h-2 inline-flex justify-center items-center mr-3 bg-gray-1000 rounded-full"></span>
                        <?php echo get_the_date(); ?>
                    </date>

                    <?php $terms = get_the_terms(get_the_ID(), 'release-note-tags'); ?>

                    <?php if ($terms && !is_wp_error($terms)): ?>
                        <ul class="flex justify-end items-center gap-2">
                            <?php foreach ($terms as $term): ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="text-sm font-medium border border-gray-300 border-solid px-3 py-1 rounded-full text-gray-600 hover:underline">
                                        <?php echo esc_html($term->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <h2 class="mt-6 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-6xl">
                    <?php the_title(); ?>
                </h2>

                <div class="prose">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </section>

    <section class="x-container">
        <?php 
            if($wp_query->max_num_pages > 1) {
                get_template_part('template-parts/pagination'); 
            };
        ?>
    </section>
<?php else: ?>
    <?php 
        get_template_part('template-parts/empty-state', null, [
            'title' => __('No Release Notes', 'documentation'),
            'description' => __('It seems that no release notes have been created yet.', 'documentation'),
            'icon' => 'notes-off',
        ]);
    ?>
<?php endif; ?>

<?php
get_footer();
