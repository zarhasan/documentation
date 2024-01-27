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

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

	<style>
		body {
			--color-primary: <?php echo esc_html(get_theme_mod("color_primary", "#31358A")); ?>;
			--color-primary-50: <?php echo esc_html(get_theme_mod("color_primary", "#31358A").'0d'); ?>;
			--color-primary-100: <?php echo esc_html(get_theme_mod("color_primary", "#31358A").'1a'); ?>;
			--color-primary-300: <?php echo esc_html(get_theme_mod("color_primary", "#31358A").'4D'); ?>;
			--color-primary-900: <?php echo esc_html(get_theme_mod("color_primary", "#31358A").'e6'); ?>;
			
			--color-primary-foreground: <?php echo esc_html(get_theme_mod("color_primary_foreground", "#fff")); ?>;

			--color-secondary: #A8DADC;
			--color-accent: #E63946;
			--color-dark: #21262c;
			--color-dark-green: #52821C;
			
			--color-red-400: #f87171;
			--color-red-300: #fca5a5;
			--color-red-700: #b91c1c;

			--color-gray-0: #ffffff;
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
			--color-gray-1000: #030712;

			--ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
			--font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			--line-height: 1.6;
		}

		body[data-color-scheme="dark"] {
			--color-gray-0: #030712;
			--color-gray-50: #111827;
			--color-gray-100: #1f2937;
			--color-gray-200: #374151;
			--color-gray-300: #4b5563;
			--color-gray-400: #6b7280;
			--color-gray-500: #9ca3af;
			--color-gray-600: #d1d5db;
			--color-gray-700: #e5e7eb;
			--color-gray-800: #f3f4f6;
			--color-gray-900: #f9fafb;
			--color-gray-1000: #ffffff;
		}
	</style>
		
</head>

<body 
	<?php body_class("bg-gray-0 text-gray-1000"); ?> 
	x-cloak 
	x-data 
	x-bind:data-color-scheme="$store.colorScheme.name">

<?php wp_body_open(); ?>

<div id="page" class="site" x-clock>

	<header 
		id="header"
		x-data="header" 
		x-on:keydown.window.ctrl.k.prevent="$store.searchPanel.show()"
		role="banner" 
		class="relative top-0 left-0 w-full h-24 z-[1001] md:py-4 flex justify-start bg-transparent border-gray-300 border-b-1 border-b-1 border-dashed items-center when-sm:border-b-1 when-sm:border-solid when-sm:border-gray-300 transition-all duration-500 ease-out-expo when-sm:h-20"
		x-bind:class="[notTop ? '' : '']">
		
		<?php get_template_part('template-parts/skip-link'); ?>

		<div class="w-full px-10 flex justify-start items-center gap-8">
			<a href="<?php echo site_url(); ?>" class="h-10 flex justify-start items-center when-sm:hidden">
				<?php get_template_part('template-parts/header-logo'); ?>
			</a>

			<button x-on:click="$store.searchPanel.show()" class="lg:max-w-3xl h-14 grow mr-auto bg-gray-100 text-gray-700 border-1 border-gray-300 border-solid rounded-full flex justify-start items-center px-4 focus-within:outline-2 focus-within:border-gray-900">
				<span class="inline-flex justify-center items-center w-6 h-6 mr-4">
					<?php echo documentation_svg('search'); ?>
				</span>

				<?php if(is_archive('docs') || is_singular('docs')): ?>
					<span>
						<?php esc_attr_e('Search in docs', 'documentation'); ?>
					</span>
				<?php else: ?>
					<span>
						<?php esc_attr_e('Search in site', 'documentation'); ?>
					</span>
				<?php endif; ?>
				
				<span class="ml-auto bg-gray-50 border-gray-300 border-1 border-solid text-xs font-semibold px-3 py-2 rounded-full">
					<?php esc_attr_e('Ctrl + K', 'documentation'); ?>
				</span>
			</button>
			
			<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container' => 'nav',
					'container_class' => 'ml-auto when-sm:hidden',
					'menu_class' => 'w-full flex justify-start gap-8 font-medium',
					'menu_id' => '',
					'fallback_cb' => false,
					'container_aria_label' => 'Primary',
				));
			?>

			<div>
				<button x-on:click="$store.colorScheme.toggle()" class="bg-gray-100 border-1 border-solid border-gray-300 w-14 h-14 inline-flex justify-center items-center text-gray-600 rounded-full">
					<span class="inline-flex justify-center items-center w-6 h-6">
						<?php echo documentation_svg('moon'); ?>
					</span>
				</button>
			</div>
		</div>

		<?php if(is_archive('docs') || is_singular('docs')): ?>
			<?php get_template_part('template-parts/search-panel', null, ['ajax_action' => 'documentation_get_documents_list', 'label' => __('Search in docs', 'documentation')]); ?>
		<?php else: ?>
			<?php get_template_part('template-parts/search-panel'); ?>
		<?php endif; ?>
	</header>

	
	<main id="content" class="site-content" role="main">