<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package documentation
 */

get_header(); 

$previous_page_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
?>

<div class="x-container flex flex-col justify-center items-start py-28 min-h-[var(--hero-height)]">
	<p class="font-bold text-sm text-gray-1000"><?php esc_html_e('404 error', 'documentation'); ?></p>
	<h1><?php esc_html_e('We can’t find that page', 'documentation'); ?></h1>
	<p><?php esc_html_e("Sorry, the page you are looking for doesn't exist or has been moved.", 'documentation'); ?></p>

	<div class="flex justify-start items-start gap-4 mt-8">
		<a 
			class="inline-flex justify-center items-center gap-2 text-base bg-gray-1000 text-gray-0 px-4 py-3" 
			href="<?php echo esc_url($previous_page_url); ?>">
			<span class="flex justify-center items-center w-5 h-auto">
				<?php echo documentation_svg('arrow-left'); ?>
			</span>
			<?php esc_html_e('Go Back', 'documentation'); ?>
		</a>

		<a class="inline-flex justify-center items-center gap-2 text-base bg-gray-1000 text-gray-0 px-4 py-3" href="<?php echo esc_url(home_url()); ?>">
			<span class="flex justify-center items-center w-5 h-auto">
				<?php echo documentation_svg('home'); ?>
			</span>
			<?php esc_html_e('Go to homepage', 'documentation'); ?>
		</a>
	</div>
</div>

<?php
get_footer();
