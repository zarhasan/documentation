<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$plugins = [
    [
        'icon' => documentation_assets('images/icon-fast-fuzzy-search.png'),
        'name' => 'Fast Fuzzy Search',
        'description' => 'Fast and lightweight search engine for WordPress and WooCommerce. It is used to provide live search functionality.',
        'status' => documentation_get_plugin_state_by_slug('fast-fuzzy-search'),
    ],
    [
        'icon' => documentation_assets('images/icon-acf.svg'),
        'name' => 'Advanced Custom Fields (ACF)',
        'description' => 'ACF is a WordPress plugin that allows you to add custom fields to your posts, pages, and custom post types. It is used to create custom fields for the documentation.',
        'status' => documentation_get_plugin_state_by_slug('advanced-custom-fields'),
    ],
    [
        'icon' => documentation_assets('images/icon-nested-pages.png'),
        'name' => 'Nested Pages',
        'description' => 'Used for the documentation page tree and drag-and-drop functionality',
        'status' => documentation_get_plugin_state_by_slug('wp-nested-pages'),
    ],
    [
        'icon' => documentation_assets('images/icon-code-block-pro.png'),
        'name' => 'Code Block Pro',
        'description' => 'Code Block Pro is a WordPress plugin that allows you to add custom code blocks to your posts, pages, and custom post types. It is used to create custom code blocks for the documentation.',
        'status' => documentation_get_plugin_state_by_slug('code-block-pro'),
    ]
];

?>

<section class="bg-white p-8 mb-8 border border-gray-300 border-solid">
    <h2 class="mb-6 mt-0"><?php esc_html_e('Essential Plugins') ?></h2>

    <ul role="list" class="divide-y divide-gray-100 flex flex-col gap-4">
        <?php foreach ($plugins as $index => $plugin): ?>
            <li class="flex items-center justify-start gap-x-6 border border-gray-300 border-solid py-4 pl-4 pr-8">
                <img class="w-20 h-auto shrink-0" src="<?php echo esc_url($plugin['icon']); ?>" alt="">

                <div class="min-w-0">
                <div class="flex items-center gap-x-3">
                    <p class="text-base font-semibold text-gray-900 m-0">
                        <?php echo esc_html($plugin['name']); ?>
                    </p>

                    <?php if($plugin['status'] === 'active'): ?>
                        <p class="m-0 whitespace-nowrap capitalize rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <?php echo esc_html($plugin['status']); ?>
                        </p>
                    <?php elseif($plugin['status'] === 'not installed'): ?>
                        <p class="m-0 whitespace-nowrap capitalize rounded-md bg-red-50 px-1.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                            <?php echo esc_html($plugin['status']); ?>
                        </p>
                    <?php else: ?>
                        <p class="m-0 whitespace-nowrap capitalize rounded-md bg-yellow-50 px-1.5 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
                            <?php echo esc_html($plugin['status']); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="mt-2 flex items-center gap-x-2 text-xs/5 text-gray-500">
                    <p class="m-0">
                        <?php echo esc_html($plugin['description']); ?>
                    </p>
                </div>
                </div>

                <div class="flex flex-none items-center gap-x-4 ml-auto">
                    <?php if($plugin['status'] === 'active'): ?>
                    <?php elseif($plugin['status'] === 'not installed'): ?>
                        <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>" class="button button-primary">Install</a>
                    <?php else: ?>
                        <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>" class="button button-primary">Activate</a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>