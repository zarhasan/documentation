<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div
  x-cloak
  x-trap="$store.searchPanel.isVisible"
  x-show="$store.searchPanel.isVisible"
  x-data="searchBox()" 
  x-transition.opacity
  class="fixed inset-0 w-full h-full z-[9999] bg-[#212121d8] flex justify-center items-start py-20 backdrop-blur-sm">

  <form 
    class="w-full lg:w-1/2 bg-white shadow-lg rounded-xl p-4"
    action="<?php home_url(); ?>"
    x-on:click.outside="$store.searchPanel.hide()">

    <div class="border-1 border-solid border-gray-300 rounded-xl flex justify-start items-center px-4 bg-gray-100 focus-within:bg-transparent">
      <span class="inline-flex justify-center items-center w-6 h-6 mr-2 text-gray-600 shrink-0">
        <?php echo documentation_svg('search'); ?>
      </span>

      <input 
        class="flex w-full !h-14 !border-none rounded-xl px-6 grow bg-transparent !outline-0"
        placeholder="<?php esc_html_e('Search in docs') ?>"
        name="query"
        type="search"
        x-ref="searchInput"
        x-model="search"
        x-on:input="searchDebounced"
        x-on:keydown.window="handleArrowNavigation"
        x-on:keydown.enter.prevent="selectResultWithEnter"
        x-on:keydown.esc.prevent="$store.searchPanel.hide()"
        id="search"
        aria-autocomplete="list"
        aria-controls="search-results"
        autocomplete="off"
      >
      <button 
        class="shrink-0 bg-gray-200 text-gray-900 p-2 text-xs font-semibold rounded ml-auto"
        x-on:click.prevent="$store.searchPanel.hide()">
        <?php esc_html_e('Esc', 'documentation'); ?>
      </button>
    </div>

    <ul 
      class="w-full bg-white text-gray-900 list-none m-0 p-0 mt-4" 
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
            class="flex justify-start items-center bg-gray-100 text-gray-700 px-4 py-4 text-sm font-medium rounded-xl w-full transition-all duration-200 ease-out-expo selected:bg-primary selected:text-white hover:bg-primary hover:text-white"
            x-bind:aria-selected="isActive(index)"
            x-bind:href="paths[index]" 
            x-show="result" 
          > 
            <span class="flex justify-center items-center bg-gray-200 text-gray-700 rounded p-2 mr-4 w-8 h-8">
              <span x-cloak x-show="paths[index].includes('#')">
                <?php echo documentation_svg('hash'); ?>
              </span>

              <span x-show="!paths[index].includes('#')">
                <?php echo documentation_svg('link'); ?>
              </span>
            </span>

            <span x-text="result"></span>
            <span 
              class="shrink-0 bg-gray-100 text-gray-900 p-2 text-xs font-semibold rounded ml-auto"
              x-bind:class="[isActive(index) ? 'opacity-100' : 'opacity-0']">
              <?php esc_html_e('Enter', 'documentation'); ?>
            </span>
          </a>
        </li>
      </template>
    </ul>

    <div class="w-full h-auto text-center p-10 text-gray-600 text-sm" x-show="!resultsVisible">
      <?php esc_html_e('Enter search term to find documents', 'documentation'); ?>
    </div>

    <div class="w-full bg-gray-100 py-2 px-4 text-gray-600 rounded-xl mt-4">
      Use <span class="inline-flex justify-center items-center w-4 h-4"><?php echo documentation_svg('arrow-narrow-up') ?></span> <span class="inline-flex justify-center items-center w-4 h-4"><?php echo documentation_svg('arrow-narrow-down') ?></span> to navigate
    </div>
  </form>
</div>