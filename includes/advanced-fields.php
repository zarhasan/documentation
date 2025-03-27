<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$id = $field['id'];
$name = $field['name'] ?? $id;
$label = $field['label'] ?? '';
$value = esc_attr($value);
$type = $field['type'];
$options = $field['options'] ?? [];
$default = $field['default'] ?? '';

?>

<div class="mb-6">
    <?php if (!empty($label)): ?>
        <label for="<?php echo esc_attr($id); ?>" class="block text-sm font-medium text-gray-700 sr-only">
            <?php echo esc_html($label); ?>
        </label>
    <?php endif; ?>

    <?php if ($type === 'text'): ?>
        <input
            type="text"
            x-model="$data.options.<?php echo esc_attr($name); ?>"
            id="<?php echo esc_attr($id); ?>"
            name="<?php echo esc_attr($name); ?>"
            value="<?php echo esc_attr($value); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />

    <?php elseif ($type === 'number'): ?>
        <input
            type="number"
            x-model="$data.options.<?php echo esc_attr($name); ?>"
            id="<?php echo esc_attr($id); ?>"
            name="<?php echo esc_attr($name); ?>"
            value="<?php echo esc_attr($value); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />

    <?php elseif ($type === 'textarea'): ?>
        <textarea
            id="<?php echo esc_attr($id); ?>"
            x-model="$data.options.<?php echo esc_attr($name); ?>"
            name="<?php echo esc_attr($name); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            rows="5"
        ><?php echo esc_textarea($value); ?></textarea>

    <?php elseif ($type === 'checkbox'): ?>
        <input
            type="checkbox"
            x-model="$data.options.<?php echo esc_attr($name); ?>"
            id="<?php echo esc_attr($id); ?>"
            name="<?php echo esc_attr($name); ?>"
            value="1"
            <?php checked($value, '1'); ?>
            class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 rounded"
        />

    <?php elseif ($type === 'checkbox_group'): ?>
        <?php foreach ($options as $option_value => $option_label): ?>
            <label class="flex justify-start items-center gap-2 mb-3">
                <input
                    type="checkbox"
                    id="<?php echo esc_attr($option_value); ?>"
                    value="<?php echo esc_attr($option_value); ?>" 
                    name="<?php echo esc_attr($name); ?>"
                    class="h-5 w-5 text-primary-700 focus:ring-primary-700 !m-0"
                    x-on:change="handleMultipleCheckboxChange"
                    x-bind:checked="handleMultipleCheckboxChecked"
                />
                <p class="!m-0 !p-0 text-sm !leading-none">
                    <?php echo esc_html($option_label); ?>
                </p>
            </label>
        <?php endforeach; ?>


    <?php elseif ($type === 'radio'): ?>
        <div class="mt-2 flex space-x-4">
            <?php foreach ($options as $option_value => $option_label): ?>
                <label class="inline-flex items-center">
                    <input
                        type="radio"
                        x-model="$data.options.<?php echo esc_attr($name); ?>"
                        name="<?php echo esc_attr($name); ?>"
                        value="<?php echo esc_attr($option_value); ?>"
                        <?php checked($value, $option_value); ?>
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                    />
                    <span class="ml-2 text-sm text-gray-700"><?php echo esc_html($option_label); ?></span>
                </label>
            <?php endforeach; ?>
        </div>

    <?php elseif ($type === 'select'): ?>
        <select
            id="<?php echo esc_attr($id); ?>"
            x-model="$data.options.<?php echo esc_attr($name); ?>"
            name="<?php echo esc_attr($name); ?>"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
            <?php foreach ($options as $option_value => $option_label): ?>
                <option value="<?php echo esc_attr($option_value); ?>" <?php selected($value, $option_value); ?>>
                    <?php echo esc_html($option_label); ?>
                </option>
            <?php endforeach; ?>
        </select>

    <?php elseif ($type === 'color_picker'): ?>
        <label 
            class="inline-flex w-auto justify-start items-stretch cursor-pointer overflow-hidden bg-gray-50 border border-solid border-gray-500 rounded p-0">
            <input
                class="w-8 m-0 p-0 !border-none !outline-none !rounded-none"
                style="block-size: auto;"
                x-ref="color_<?php echo esc_attr($name); ?>"
                type="color"
                x-model="$data.options.<?php echo esc_attr($name); ?>"
                id="<?php echo esc_attr($id); ?>"
                name="<?php echo esc_attr($name); ?>"
                value="<?php echo esc_attr($value); ?>"
            />
            <span class="text-sm inline-flex px-2 py-1 pointer-events-none font-semibold"><?php esc_html_e('Primary Color', 'fast-fuzzy-search') ?></span>
        </label>

    <?php elseif ($type === 'range'): ?>
        <input
            type="range"
            x-model="$data.options.<?php echo esc_attr($name); ?>"
            id="<?php echo esc_attr($id); ?>"
            name="<?php echo esc_attr($name); ?>"
            min="<?php echo esc_attr($field['min'] ?? 0); ?>"
            max="<?php echo esc_attr($field['max'] ?? 100); ?>"
            step="<?php echo esc_attr($field['step'] ?? 1); ?>"
            value="<?php echo esc_attr($value); ?>"
            class="w-full"
            x-data="{ rangeValue: <?php echo esc_attr($value); ?> }"
            x-on:input="rangeValue = $event.target.value"
        />
        <span class="text-sm text-gray-700" x-text="rangeValue"></span>

    <?php elseif ($type === 'switch'): ?>

        <div class="focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#2271b1]">
            <input 
                type="checkbox"
                x-model="$data.options.<?php echo esc_attr($name); ?>"
                id="<?php echo esc_attr($id); ?>"
                name="<?php echo esc_attr($name); ?>"
                value="1"
                <?php checked($value, '1'); ?>
                class="sr-only peer"
            />
            <label 
                for="<?php echo esc_attr($name); ?>"
                class="inline-flex justify-start items-center px-1 h-6 w-9 rounded-full bg-gray-300 peer-checked:bg-green-500 transition-colors cursor-pointer relative peer-checked:justify-end"
            >
                <span class="h-4 w-4 bg-white rounded-full shadow-md"></span>
            </label>

            <span class="ml-3 text-sm font-medium text-gray-700">
                <?php echo esc_html($field['description'] ?? ''); ?>
            </span>
        </div>

    <?php elseif ($type === 'image_radio'): ?>
        <div class="flex flex-wrap gap-4">
            <?php foreach ($options as $option_value => $option): ?>
                <label 
                    x-on:click="selected = '<?php echo esc_attr($option_value); ?>'" 
                    class="p-4 pt-3 bg-white border border-solid border-gray-300 rounded-md cursor-pointer <?php echo !documentation_is_pro() && !empty($option['pro']) && $option['pro'] === true ? 'fast-fuzzy-search-pro-label' : '' ?>"
                    x-bind:class="{ 'border-[#2271b1] shadow-[0_0_0_1px_#2271b1]': $data.options.<?php echo esc_attr($name); ?> === '<?php echo esc_attr($option_value); ?>', 'border-gray-300': $data.options.<?php echo esc_attr($name); ?> !== '<?php echo esc_attr($option_value); ?>' }">
                    <div class="flex justify-start items-center gap-2 mb-3">
                        <input
                            x-model="$data.options.<?php echo esc_attr($name); ?>"
                            class="!flex !justify-center !items-center !m-0"
                            type="radio"
                            name="<?php echo esc_attr($name); ?>"
                            value="<?php echo esc_attr($option_value); ?>"
                            <?php if(!documentation_is_pro() && !empty($option['pro']) && $option['pro'] === true): ?>
                                disabled="disabled"
                            <?php endif; ?>
                        />
                        <h3 class="m-0 p-0 text-sm">
                            <?php echo esc_html($option['label']); ?>
                        </h3>
                    </div>
                    <img
                        src="<?php echo esc_url($option['image']); ?>"
                        class="w-56 h-auto border-2 rounded-md object-cover"
                        x-bind:class="{ 'border-indigo-500': $data.options.<?php echo esc_attr($name); ?> === '<?php echo esc_attr($option_value); ?>', 'border-gray-300': $data.options.<?php echo esc_attr($name); ?> !== '<?php echo esc_attr($option_value); ?>' }"
                    />
                </label>
            <?php endforeach; ?>
        </div>

    <?php elseif ($type === 'tabbed_radio'): ?>
        <div class="flex flex-wrap gap-4">
            <div class="flex justify-center items-center p-2 gap-2 bg-white border border-solid border-gray-300 rounded-md">
                <?php foreach ($options as $option_value => $option): ?>
                    <label 
                        x-on:click="selected = '<?php echo esc_attr($option_value); ?>'" 
                        class="px-4 py-2 cursor-pointer rounded"
                        x-bind:class="{ 'bg-[#2271b1] text-white': $data.options.<?php echo esc_attr($name); ?> === '<?php echo esc_attr($option_value); ?>', 'border-gray-300': $data.options.<?php echo esc_attr($name); ?> !== '<?php echo esc_attr($option_value); ?>' }">
                        <div class="flex justify-start items-center gap-2">
                            <input
                                x-model="$data.options.<?php echo esc_attr($name); ?>"
                                class="!hidden"
                                type="radio"
                                name="<?php echo esc_attr($name); ?>"
                                value="<?php echo esc_attr($option_value); ?>"
                                <?php if(!documentation_is_pro() && !empty($option['pro']) && $option['pro'] === true): ?>
                                    disabled="disabled"
                                <?php endif; ?>
                            />
                            <h3 class="m-0 p-0 text-sm text-inherit">
                                <?php echo esc_html($option['label']); ?>
                            </h3>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <?php foreach ($options as $option_value => $option): ?>
                <div class="w-full" x-show="$data.options.<?php echo esc_attr($name); ?> === '<?php echo esc_attr($option_value); ?>'">
                    <?php get_template_part($option['template']); ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif ($type === 'file'): ?>
        <input
            type="file"
            id="<?php echo esc_attr($id); ?>"
            name="<?php echo esc_attr($name); ?>"
            class="mt-1 block w-full text-sm text-gray-700 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
        />

    <?php elseif ($type === 'date'): ?>
        <input
            type="date"
            id="<?php echo esc_attr($id); ?>"
            name="<?php echo esc_attr($name); ?>"
            value="<?php echo esc_attr($value); ?>"
            class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
        />

    <?php elseif ($type === 'repeater'): ?>
        <div x-data="{ items: <?php echo json_encode($value ? json_decode($value) : []); ?> }">
            <template x-for="(item, index) in items" :key="index">
                <div class="flex space-x-2 mt-2">
                    <input
                        type="text"
                        x-model="items[index]"
                        name="<?php echo esc_attr($name); ?>[]"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    <button type="button" x-on:click="items.splice(index, 1)" class="text-red-500">Remove</button>
                </div>
            </template>
            <button type="button" x-on:click="items.push('')" class="mt-2 text-indigo-500">Add Item</button>
        </div>
    <?php endif; ?>
</div>
