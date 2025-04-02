document.addEventListener("alpine:init", () => {

    Alpine.data('optionsForm', () => ({
        options: {},
        message: '',
        state: 'idle',
        async init() {
            this.$root.addEventListener('submit', async (event) => {
                event.preventDefault();

                this.$root.querySelector('input[type="submit"]')?.setAttribute('disabled', true);
                
                await this.save();

                this.$root.querySelector('input[type="submit"]')?.removeAttribute('disabled');
            });

            await this.fetchOptions();
        },

        async fetchOptions() {
            this.state = 'loading';

            try {
                const response = await fetch(FastFuzzySearch.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'fast_fuzzy_search_get_initial_options',
                        security: FastFuzzySearch._wpnonce,
                    }),
                });

                const result = await response.json();

                this.options = isEmpty(result.data) ? {} : result.data;
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.state = 'ready';
            }
        },

        async save() {
            this.state = 'updating';

            try {
                const response = await fetch(FastFuzzySearch.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'fast_fuzzy_search_save_custom_options',
                        security: FastFuzzySearch._wpnonce,
                        options: JSON.stringify(this.options),
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    this.message = result.data.message;
                } else {
                    this.message = result.data.message || 'Failed to save options.';
                }
            } catch (error) {
                this.state = 'error';
                this.message = 'An error occurred. Please try again.';
            } finally {
                this.state = 'saved';
            }
        },

        handleMultipleCheckboxChange($event) {
            const name = this.$el.getAttribute('name');
            const value = this.$el.getAttribute('value');

            if($event.target.checked) {
                if(!this.options[name].includes(value)) {
                    this.options[name].push(value)
                }
            } else {
                this.options[name] = this.options[name].filter(option => option !== value) 
            }
        },

        handleMultipleCheckboxChecked() {
            const name = this.$el.getAttribute('name');
            const value = this.$el.getAttribute('value');

            return this.options[name]?.includes(value);
        }
    }));

    console.log('alpine:init');
});


function isEmpty(value) {
    if (value == null) {
        // Check for null or undefined
        return true;
    }

    if (typeof value === 'string' || Array.isArray(value)) {
        // Check if string or array is empty
        return value.length === 0;
    }

    if (value instanceof Map || value instanceof Set) {
        // Check if Map or Set is empty
        return value.size === 0;
    }

    if (typeof value === 'object') {
        // Check if it's a plain object and has no own properties
        return Object.keys(value).length === 0;
    }

    // For other types (e.g., numbers, booleans, functions), they are not "empty"
    return false;
}