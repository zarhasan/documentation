<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package documentation
 */

if ($args) {
	extract($args);
}

?>

<div 
    x-data="docsCard"
    class="group relative flex flex-col border-frost-300 border-solid border bg-frost-0">
    <div class="p-8">
        <div class="flex justify-start items-center gap-4">
            <span class="inline-flex w-8 h-8 p-2 rounded border border-solid bg-<?php echo esc_attr($color); ?>-50 text-<?php echo esc_attr($color); ?>-700 border-<?php echo esc_attr($color); ?>-700">
                <?php echo documentation_svg('book'); ?>
            </span>

            <h3 class="text-lg leading-6 text-frost-900">
                <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
                    <?php echo esc_html($document['title']); ?>
                </a>
            </h3>
        </div>

        <div class="mt-8">
            

            <ul class="mt-4 text-base text-frost-700 grid grid-cols-3 gap-x-4 gap-y-3 list-disc pl-4">
                <?php foreach ($document['children'] as $index => $children): ?>
                    <li 
                        data-index="<?php echo esc_attr($index); ?>">
                        <a class="w-full inline-flex justify-start items-start hover:underline" href="<?php echo esc_attr($children['permalink']); ?>">
                            <?php echo esc_html($children['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <span class="pointer-events-none absolute right-6 top-6 text-frost-300 group-hover:text-frost-400" aria-hidden="true">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
            </svg>
        </span>
    </div>

    <div class="w-full px-8 py-4 bg-frost-50 text-frost-700 border-t border-frost-300 text-sm font-semibold flex justify-between items-center mt-auto">
        <span><?php echo count($document['children']); ?> <?php esc_html_e('Topics', 'documentation'); ?></span>
    </div>
</div>