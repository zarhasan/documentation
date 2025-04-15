<?php

/**
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */


$theme_options = get_option('documentation_options', documentation_get_default_options());
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<?php wp_head(); ?>

	<style>
		@font-face {
			font-family: 'Roboto Serif';
			src: url('<?php echo documentation_assets('fonts/RobotoSerif-Medium.woff2') ?>') format('woff2');
			font-weight: 500;
			font-style: normal;
		}

		@font-face {
			font-family: 'Open Sans';
			src: url('<?php echo documentation_assets('fonts/OpenSans-Regular.woff2') ?>') format('woff2');
			font-weight: 400;
			font-style: normal;
		}

		@font-face {
			font-family: 'Open Sans';
			src: url('<?php echo documentation_assets('fonts/OpenSans-Medium.woff2') ?>') format('woff2');
			font-weight: 500;
			font-style: normal;
		}

		@font-face {
			font-family: 'Open Sans';
			src: url('<?php echo documentation_assets('fonts/OpenSans-SemiBold.woff2') ?>') format('woff2');
			font-weight: 600;
			font-style: normal;
		}

		@font-face {
			font-family: 'Open Sans';
			src: url('<?php echo documentation_assets('fonts/OpenSans-Bold.woff2') ?>') format('woff2');
			font-weight: 700;
			font-style: normal;
		}

		<?php $primary_color = !empty($theme_options['color_primary']) ? $theme_options['color_primary'] : "#31358A"; ?>

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

			--color-frost-0: #ffffff;
			--color-frost-50: #f9fafb;
			--color-frost-100: #f3f4f6;
			--color-frost-200: #e5e7eb;
			--color-frost-300: #d1d5db;
			--color-frost-400: #9ca3af;
			--color-frost-500: #6b7280;
			--color-frost-600: #4b5563;
			--color-frost-700: #374151;
			--color-frost-800: #1f2937;
			--color-frost-900: #111827;
			--color-frost-1000: #030712;

			--ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
			--font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			--line-height: 1.6;
		}

		<?php $primary_color__dark_mode = !empty($theme_options['color_primary_dark']) ? $theme_options['color_primary_dark'] : '#6f73cc'; ?>

		body[data-color-scheme="dark"] {
			--color-primary: <?php echo esc_html($primary_color__dark_mode); ?>;
			--color-primary-50: <?php echo esc_html($primary_color__dark_mode.'0d'); ?>;
			--color-primary-100: <?php echo esc_html($primary_color__dark_mode.'1a'); ?>;
			--color-primary-300: <?php echo esc_html($primary_color__dark_mode.'4D'); ?>;
			--color-primary-900: <?php echo esc_html($primary_color__dark_mode.'e6'); ?>;

			--color-frost-0: #171717;
			--color-frost-50: #0a0a0a;
			--color-frost-100: #262626;
			--color-frost-200: #404040;
			--color-frost-300: #525252;
			--color-frost-400: #737373;
			--color-frost-500: #a3a3a3;
			--color-frost-600: #d4d4d4;
			--color-frost-700: #e5e5e5;
			--color-frost-800: #f5f5f5;
			--color-frost-900: #fafafa;
			--color-frost-1000: #ffffff;
		}
	</style>
		
</head>

<body 
	<?php body_class("bg-frost-50 text-frost-1000"); ?> 
	x-cloak 
	x-data="page"
	data-color-scheme="<?php echo !empty($theme_options['default_color_scheme']) ? $theme_options['default_color_scheme'] : 'light' ; ?>"
	x-bind:data-color-scheme="colorSchemeName">

<?php wp_body_open(); ?>

<div id="page" class="site bg-frost-50 text-frost-1000" x-clock>

	<header 
		id="header"
		x-data="header" 
		x-on:keydown.window.ctrl.k.prevent="showSearch"
		role="banner" 
		class="absolute top-0 left-0 w-full h-16 sm:h-24 z-[1001] flex justify-start items-center transition-all duration-500 ease-out-expo admin-bar:top-14 sm:admin-bar:top-8 print:hidden"
		x-bind:class="headerClass">
		
		<?php get_template_part('template-parts/skip-link'); ?>

		<div class="w-full x-container flex justify-start items-center gap-x-8 gap-y-4 sm:gap-0">
			<a href="<?php echo site_url(); ?>" class="w-60 sm:w-80 py-2 pr-16">
				<?php if(has_custom_logo()): ?>
					<span class="h-14 flex justify-start items-center">
						<?php get_template_part('template-parts/header-logo'); ?>
					</span>
				<?php else: ?>
					<span class="flex justify-start items-start flex-col gap-2">
						<span class="text-sm sm:text-lg font-bold text-frost-900"><?php echo get_bloginfo('name'); ?></span>
					</span>
				<?php endif; ?>
			</a>

			<?php if(defined('FAST_FUZZY_SEARCH_VERSION')): ?>
				<?php get_template_part('template-parts/header-search-button', null, ['classes' => 'hidden !sm:flex']); ?>
			<?php endif; ?>
			
			<div class="flex justify-end items-center w-auto shrink-0 ml-auto sm:pl-8 gap-6">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'container' => 'nav',
						'container_class' => 'desktop ml-auto hidden lg:flex pl-8',
						'container_aria_label' => 'Primary',
						'menu_class' => '',
						'menu_id' => '',
						'fallback_cb' => false,
					));
				?>

				<?php
					if(function_exists('pll_the_languages')) {
						pll_the_languages( array( 'dropdown' => 1 ) );
					};
				?>

				<?php if(defined('FAST_FUZZY_SEARCH_VERSION')): ?>
					<?php get_template_part('template-parts/header-search-icon-button', null, ['classes' => '!sm:hidden']); ?>
				<?php endif; ?>

				<button x-on:click="colorSchemeToggle" class="w-6 h-6 inline-flex justify-center items-center text-frost-600">
					<span x-show="isLight" class="inline-flex justify-center items-center">
						<?php echo documentation_svg('moon'); ?>
					</span>

					<span x-cloak x-show="isDark" class="inline-flex justify-center items-center">
						<?php echo documentation_svg('sun'); ?>
					</span>
				</button>

				<button 
					x-on:click.prevent="handleMenuButtonClick"
					class="w-6 h-6 inline-flex justify-center items-center text-frost-600 !lg:hidden"
					>
					<span x-show="isSidebarHidden">
						<?php echo documentation_svg('menu'); ?>
					</span>
					<span x-cloak x-show="isSidebarVisible">
						<?php echo documentation_svg('x'); ?>
					</span>
				</button>
			</div>

		</div>

		<div 
			x-cloak
            class="fixed top-0 right-0 w-96 bottom-0 lg:hidden" 
            style="z-index: 1000;"
            x-show="showSidebar"
            x-trap.inert="showSidebar"
            xyz="fade right-5 duration-2"
			x-transition:enter="xyz-in"
			x-transition:leave="xyz-out"
            x-on:keydown.escape.window="handleSidebarWindowEscape">

            <div class="x-container h-full bg-frost-50 border border-frost-300 py-8">
				<div class="w-full flex justify-end items-center mb-4">
					<button 
						x-on:click.prevent="handleMenuButtonClick"
						class="w-6 h-6 inline-flex justify-center items-center text-frost-600 !lg:hidden">
						<span x-cloak x-show="isSidebarVisible">
							<?php echo documentation_svg('x'); ?>
						</span>
					</button>
				</div>

                <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => '',
                        'container' => 'nav',
                        'container_aria_label' => 'Primary',
                        'container_class' => 'primary--mobile',
                    ]);
                ?>
            </div>
        </div>
	</header>

	
	<main id="content" class="site-content pt-16 sm:pt-24" role="main">
		<?php if(has_nav_menu('secondary')): ?>
			<div class="x-container relative z-1000">
				<?php
					wp_nav_menu([
						'theme_location' => 'secondary',
						'menu_class' => 'flex justify-start items-center flex-wrap w-full gap-4 mt-8 whitespace-nowrap bg-frost-0 border border-frost-200 p-2',
						'container' => 'nav',
						'container_aria_label' => 'Secondary',
						'container_class' => 'desktop--secondary',
					]);
				?>
			</div>
		<?php endif; ?>