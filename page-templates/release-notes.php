<?php
/**
 * Template Name: Release Notes
 *
 */

get_header(); 

?>

<div x-data="changelog" class="px-10 mx-auto py-16">
    <div class="flex flex-col justify-start items-start gap-4">
        <template x-for="item in jsonValue">
            <div class="w-full bg-gray-0 border-1 border-solid border-gray-200">
                <button class="p-4 w-full flex items-center justify-between text-left">
                    <span class="w-4 h-4 inline-flex justify-center items-center mr-2"><?php echo documentation_svg('file-text'); ?></span>
                    <span class="font-semibold pr-2" x-text="item.version"></span>
                    <span class="mr-auto" x-text="item.product"></span>

                    <div class="flex justify-start items-start flex-wrap gap-1 mr-2">
                        <template x-for="change in item.changes">
                            <span class="inline-flex text-xs font-semibold bg-gray-100 border-1 border-gray-300 rounded-full px-2 py-1 shrink-0" x-text="change.name"></span>
                        </template>
                    </div>

                    <span class="text-sm" x-text="item.date"></span>
                    <span class="w-5 h-5 inline-flex justify-center items-center ml-2">
                        <?php echo documentation_svg('chevron-down') ?>
                    </span>
                </button>

                <div class="p-4">
                    <template x-for="change in item.changes">
                        <template x-if="change.log.length > 0">
                            <div>
                                <h2 class="font-semibold m-0 text-base" x-text="change.name"></h2>
                                <ul class="mb-4 mt-2 flex flex-col gap-2 list-disc pl-4 text-sm text-gray-800">
                                    <template x-for="log in change.log">
                                        <li>
                                            <span x-text="log.description"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <textarea x-ref="textarea" class="hidden" id="changelog">
        <?php echo get_field('release_notes'); ?>  
    </textarea>  
</div>

<?php
get_footer();
