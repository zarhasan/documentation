<?php

/**
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<?php wp_head(); ?>

	<style>
		:root {
			--color-primary: <?php echo esc_html(get_theme_mod("color_primary", "#826030")); ?>;
			--color-primary-800: #8F7145;
			--color-primary-50: #D9D9D933;
			--color-primary-100: #E7E1D8;
			--color-primary-900: <?php echo esc_html(get_theme_mod("color_primary", "#826030").'e6'); ?>;
			--color-secondary: #A8DADC;
			--color-accent: #E63946;
			--color-dark: #21262c;
			--color-dark-green: #52821C;
			
			--color-red-400: #f87171;
			--color-red-300: #fca5a5;
			--color-red-700: #b91c1c;

			--color-gray-50: #f9fafb;
			--color-gray-100: #f3f4f6;
			--color-gray-200: #e5e7eb;
			--color-gray-300: #d1d5db;
			--color-gray-400: #9ca3af;
			--color-gray-500: #6b7280;
			--color-gray-600: #4b5563;
			--color-gray-700: #374151;
			--color-gray-800: #1f2937;
			--color-gray-900: #111827;
			--color-gray-950: #030712;

			--ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
			--font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			--line-height: 1.6;
		}
	</style>
		
</head>

<body <?php body_class("bg-white bg-contain bg-center"); ?> style="background-image: url('<?php echo documentation_assets('images/background_pattern.png') ?>') ">

<?php wp_body_open(); ?>

<div id="page" class="site" x-clock>

	<header 
			id="header"
			x-data="header" 
			role="banner" 
			class="relative top-0 left-0 w-full h-32 z-[1001] md:py-4 flex justify-start bg-transparent border-1 border-b-1 border-solid items-center when-sm:border-b-1 when-sm:border-solid when-sm:border-gray-300 transition-all duration-500 ease-out-expo when-sm:h-20"
			x-bind:class="[notTop ? '' : '']">
			
			<?php get_template_part('template-parts/skip-link'); ?>

			<div class="container">
				<div class="w-52 flex justify-center items-center when-sm:w-36">
					<?php get_template_part('template-parts/header-logo'); ?>
				</div>
			</div>
	</header>

	
	<main id="content" class="site-content" role="main">