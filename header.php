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
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"
	/>

	<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>

	<style>
		<?php $primary_color = get_theme_mod("color_primary", "#31358A"); ?>

		body {
			--color-primary: <?php echo esc_html($primary_color); ?>;
			--color-primary-50: <?php echo esc_html($primary_color.'0d'); ?>;
			--color-primary-100: <?php echo esc_html($primary_color.'1a'); ?>;
			--color-primary-300: <?php echo esc_html($primary_color.'4D'); ?>;
			--color-primary-900: <?php echo esc_html($primary_color.'e6'); ?>;
			
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

		<?php $primary_color__dark_mode = get_theme_mod("color_primary_dark", '#6f73cc'); ?>

		body[data-color-scheme="dark"] {
			--color-primary: <?php echo esc_html($primary_color__dark_mode); ?>;
			--color-primary-50: <?php echo esc_html($primary_color__dark_mode.'0d'); ?>;
			--color-primary-100: <?php echo esc_html($primary_color__dark_mode.'1a'); ?>;
			--color-primary-300: <?php echo esc_html($primary_color__dark_mode.'4D'); ?>;
			--color-primary-900: <?php echo esc_html($primary_color__dark_mode.'e6'); ?>;

			--color-gray-0: #000000;
			--color-gray-50: #030712;
			--color-gray-100: #111827;
			--color-gray-200: #1f2937;
			--color-gray-300: #374151;
			--color-gray-400: #4b5563;
			--color-gray-500: #6b7280;
			--color-gray-600: #9ca3af;
			--color-gray-700: #d1d5db;
			--color-gray-800: #e5e7eb;
			--color-gray-900: #f3f4f6;
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

<div id="page" class="site bg-gray-50 text-gray-700" x-clock>

	<header 
		id="header"
		x-data="header" 
		x-on:keydown.window.ctrl.k.prevent="$store.searchPanel.show()"
		role="banner" 
		class="absolute top-0 left-0 w-full h-32 sm:h-24 z-[1001] flex justify-start items-center transition-all duration-500 ease-out-expo"
		x-bind:class="[notTop ? '' : '']">
		
		<?php get_template_part('template-parts/skip-link'); ?>

		<div class="w-full x-container flex justify-start items-center gap-x-8 gap-y-4 flex-wrap sm:gap-0">
			<a href="<?php echo site_url(); ?>" class="w-40 sm:w-80 py-2 pr-4">
				<?php if(has_custom_logo()): ?>
					<span class="h-14 flex justify-start items-center">
						<?php get_template_part('template-parts/header-logo'); ?>
					</span>
				<?php else: ?>
					<span class="flex justify-start items-start flex-col gap-2">
						<span class="text-sm sm:text-lg font-bold text-gray-900"><?php echo get_bloginfo('name'); ?></span>
					</span>
				<?php endif; ?>
			</a>

			<?php get_template_part('template-parts/header-search-button', null, ['classes' => 'hidden sm:flex']); ?>
			
			<div class="flex justify-end items-center w-auto shrink-0 ml-auto sm:pl-8 gap-6">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'container' => 'nav',
						'container_class' => 'desktop ml-auto when-sm:hidden pl-8',
						'menu_class' => '',
						'menu_id' => '',
						'fallback_cb' => false,
						'container_aria_label' => 'Primary',
					));
				?>

				<button x-on:click="$store.colorScheme.toggle()" class="w-6 h-6 inline-flex justify-center items-center text-gray-600">
					<span x-show="$store.colorScheme.name === 'light'" class="inline-flex justify-center items-center">
						<?php echo documentation_svg('moon'); ?>
					</span>

					<span x-cloak x-show="$store.colorScheme.name === 'dark'" class="inline-flex justify-center items-center">
						<?php echo documentation_svg('sun'); ?>
					</span>
				</button>

				<button 
					x-on:click.prevent="showSidebar ? hide('showSidebar') : show('showSidebar')"
					class="w-6 h-6 inline-flex justify-center items-center text-gray-600 lg:hidden"
					>
					<span x-show="!showSidebar">
						<?php echo documentation_svg('menu'); ?>
					</span>
					<span x-cloak x-show="showSidebar">
						<?php echo documentation_svg('x'); ?>
					</span>
				</button>
			</div>

			<?php get_template_part('template-parts/header-search-button', null, ['classes' => 'sm:hidden']); ?>
		</div>



		<?php if(is_archive('docs') || is_singular('docs')): ?>
			<?php get_template_part('template-parts/search-panel', null, ['ajax_action' => 'documentation_get_documents_list', 'label' => __('Search in docs', 'documentation')]); ?>
		<?php else: ?>
			<?php get_template_part('template-parts/search-panel'); ?>
		<?php endif; ?>

		<div 
            class="fixed top-32 sm:top-24 right-0 w-96 bottom-0 lg:hidden py-8" 
            style="z-index: 1000;"
            x-cloak
            x-show="showSidebar"
            x-trap.inert="showSidebar"
            x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0 translate-x-28"
			x-transition:enter-end="opacity-100 translate-x-0"
			x-transition:leave="transition ease-in duration-300"
			x-transition:leave-start="opacity-100 translate-x-0"
			x-transition:leave-end="opacity-0 translate-x-28"
            x-on:keydown.escape.window="hide('showSidebar')">

            <div class="x-container h-full bg-gray-50 border-l border-gray-200 py-8">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => '',
                        'container' => 'nav',
                        'container_aria_label' => 'Primary',
                        'container_class' => 'mobile',
                    ));
                ?>
            </div>
        </div>
	</header>

	
	<main id="content" class="site-content pt-32 sm:pt-24" role="main">