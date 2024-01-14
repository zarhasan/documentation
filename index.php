<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header();

$posts_page_id = get_option('page_for_posts');

?>

<?php get_template_part('template-parts/subheader'); ?>

<div id="primary" class="content-area">
	<?php $card_type = get_theme_mod('blog_card_type', 'default'); ?>

    <div class="max-w-2xl mx-auto flex-grow self-stretch mb-16">

        <?php if (is_home()): ?>
            <div class="text-center mt-16">
                <h1 class="text-6xl mb-4"><?php single_post_title();?></h1>

                <?php if(function_exists('get_field')): ?>
                    <div class="text-lg mt-2">
                        <?php $description = get_field('description', $posts_page_id); ?>
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()): ?>
            <div class="posts flex flex-col gap-12 my-12">

            <?php 
                global $wp_query;

                while (have_posts()): the_post();

                get_template_part('template-parts/post-card', $card_type.get_post_format());

                endwhile;
            ?>
            </div>

        <?php 
            if($wp_query->max_num_pages > 1) {
                get_template_part('template-parts/pagination'); 
            }
        ?>

        <?php 

            else:

            get_template_part( 'template-parts/content/none');

            endif;
        ?>

    </div>
</div><!-- #primary -->


<?php
get_footer();