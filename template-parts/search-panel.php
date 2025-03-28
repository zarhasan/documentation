<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$ajax_action = !empty($ajax_action) ? $ajax_action : 'documentation_get_posts_list';
$label = !empty($label) ? $label : __('Search in site', 'documentation');

?>

<div
  x-cloak
  x-trap.noreturn="$store.searchPanel.isVisible"
  x-show="$store.searchPanel.isVisible"
  x-data="searchPanel('<?php echo esc_attr($ajax_action); ?>')" 
  class="fixed inset-0 w-full h-full z-[9999] bg-[#212121d8] flex justify-center items-start p-20 backdrop-blur-sm when-sm:p-6">
  <form 
    class="flex flex-col w-full max-h-full grow lg:max-w-3xl bg-frost-0 shadow-lg p-6 pb-4"
    action="<?php home_url(); ?>"
    x-on:click.outside="$store.searchPanel.hide()">

    <div class="border-b-2 border-solid border-frost-1000 flex justify-start items-center focus-within:bg-transparent">
      <span class="inline-flex justify-center items-center w-6 h-6 mr-2 text-frost-600 shrink-0">
        <?php echo documentation_svg('search'); ?>
      </span>

      <input 
        class="flex w-full !h-14 !border-none rounded-xl px-6 grow bg-transparent !outline-0"
        placeholder="<?php echo esc_html($label); ?>"
        name="query"
        type="search"
        x-ref="searchInput"
        x-model="$store.searchPanel.query"
        x-on:input="searchDebounced"
        x-on:site-search.window="searchDebounced"
        x-on:keydown.window="handleArrowNavigation"
        x-on:keydown.enter.prevent="selectResultWithEnter"
        x-on:keydown.esc.prevent="$store.searchPanel.hide()"
        id="search"
        aria-autocomplete="list"
        aria-controls="search-results"
        autocomplete="off"
        style="outline: none !important;"
      >
      <button 
        class="ml-auto bg-frost-50 border-frost-300 border-1 border-solid text-xs font-semibold px-3 py-2 rounded-full shrink-0"
        x-on:click.prevent="$store.searchPanel.hide()">
        <?php esc_html_e('Esc', 'documentation'); ?>
      </button>
    </div>

    <ul 
      x-cloak
      class="w-full grow scrollbar overflow-y-scroll bg-frost-0 text-frost-1000 list-none m-0 px-1 mt-4" 
      id="search-results" 
      role="listbox" 
      aria-label="Search results" 
      x-show="resultsVisible">

      <template x-for="(result, index) in searchResults" :key="index">
        <li 
          class="py-2 w-full" 
          role="option" 
          x-on:click="selectResult(result)" 
          >
          <a 
            class="flex justify-start items-center text-frost-700 px-4 py-4 text-sm font-medium overflow-hidden w-full transition-all duration-200 ease-out-expo selected:bg-frost-100 hover:bg-frost-100"
            x-bind:aria-selected="isActive(index)"
            x-bind:href="paths[index]" 
            x-show="result" 
            x-bind:data-index="index"
          > 
            <span class="flex justify-center items-center bg-frost-200 text-frost-700 rounded p-2 mr-4 w-8 h-8 shrink-0">
              <span x-cloak x-show="paths[index] && paths[index].includes('#')">
                <?php echo documentation_svg('hash'); ?>
              </span>

              <span x-show="paths[index] && !paths[index].includes('#')">
                <?php echo documentation_svg('link'); ?>
              </span>
            </span>

            <span class="flex flex-col justify-center gap-2">
              <span class="font-bold" x-text="result.split('<?php echo DOCUMENTATION_JOIN_SYMBOL; ?>').at(-1)"></span>
              <span class="text-xs text-frost-700" x-text="result.split('<?php echo DOCUMENTATION_JOIN_SYMBOL; ?>').at(0)"></span>
            </span>

            <span 
              class="ml-auto bg-frost-50 text-frost-900 border-frost-300 border-1 border-solid text-xs font-semibold px-3 py-2 rounded-full shrink-0"
              x-bind:class="[isActive(index) ? 'opacity-100' : 'opacity-0']">
              <?php esc_html_e('Enter', 'documentation'); ?>
            </span>
          </a>
        </li>
      </template>
    </ul>

    <div class="w-full h-auto text-center p-10 text-frost-600 text-sm" x-show="!resultsVisible || searchResults.length < 1">
      <?php esc_html_e('Enter search term to find documents', 'documentation'); ?>
    </div>

    <div class="text-xs font-semibold mt-4">
      <?php echo sprintf(__('Press %s %s to navigate, %s to select, and %s to close', 'documentation'), '<kbd>'.documentation_svg('arrow-narrow-up').'</kbd>', '<kbd>'.documentation_svg('arrow-narrow-down').'</kbd>',  '<kbd>'.documentation_svg('arrow-back').'</kbd>', '<kbd>'.__('Esc', 'documentation').'</kbd>') ?>
    </div>
  </form>
</div>