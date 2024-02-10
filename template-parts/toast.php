<div x-data class="fixed bottom-4 right-4 flex flex-col gap-4" x-show="$store.toast.entries.length > 0"
    x-transition:enter="transition ease-out duration-100 transform origin-bottom"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300 transform origin-bottom"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">
    <template x-for="(toast, index) in $store.toast.entries" x-bind:key="index">
        <div
            class="bg-white p-4 rounded-lg shrink-0 w-96 flex gap-2 border-1 border-solid border-gray-300 justify-start items-center focus-within:border-primary">
            <div class="grow flex flex-col gap-2 outline-non max-w-[90%]" tabindex="-1">
                <h2 class="text-sm font-semibold" x-text="toast.title"></h2>
                <p class="text-sm break-all" x-html="toast.message"></p>
            </div>

            <button class="shrink-0 ml-auto text-primary" x-on:click="$store.toast.dismiss(index)">
                <?php echo documentation_svg('square-rounded-x-filled'); ?>
            </button>
        </div>
    </template>
</div>