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

<div class="container flex flex-col justify-center items-start py-28 min-h-[var(--hero-height)]">
	<p class="font-bold text-sm text-primary"><?php esc_html_e('404 error', 'documentation'); ?></p>
	<h1><?php esc_html_e('We can’t find that page', 'documentation'); ?></h1>
	<p><?php esc_html_e( "Sorry, the page you are looking for doesn't exist or has been moved.", 'documentation') ?></p>

	<div class="flex justify-start items-start gap-4 mt-8">
		<?php if (!empty($previous_page_url)): ?>
			
		<?php endif; ?>
		<a class="button button--secondary gap-2" href="<?php echo esc_url($previous_page_url); ?>">
				<span class="flex justify-center items-center w-5 h-auto">
					<?php echo documentation_svg('arrow-left'); ?>
				</span>
				<?php esc_html_e('Go Back', 'documentation'); ?>
			</a>

		<a class="button button--primary" href="<?php echo esc_url(home_url()); ?>">
			<?php esc_html_e('Go to homepage', 'documentation'); ?>
		</a>
	</div>
</div>

<?php
get_footer();
