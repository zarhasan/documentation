document.addEventListener("alpine:init", () => {
    Alpine.store('searchPanel', {
        isVisible: false,
        query: '',
        loading: true,

        toggle() {
            this.isVisible = !this.isVisible
        },

        show() {
            this.isVisible = true
        },

        hide() {
            this.isVisible = false
        }
    });

    Alpine.store('colorScheme', {
        name: 'light',

        init() {
            const fromStorage = localStorage.getItem('colorScheme');

            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                this.name = 'dark'
            }

            if (fromStorage) {
                this.name = fromStorage
            }
        },

        set(value) {
            if (!['light', 'dark'].includes(value)) {
                return
            };

            this.name = value
            localStorage.setItem('colorScheme', this.name);
        },

        toggle() {
            if (this.name == 'light') {
                this.set('dark');
            } else {
                this.set('light');
            }
        }
    });

    Alpine.store('toast', {
        entries: [],
        add(title, message, type, duration = -1) {
            const id = randomId();
            const safeMessage = new DOMParser().parseFromString(message, 'text/html');

            this.entries.push({
                id: id,
                title: title,
                message: message,
                type: type,
            });

            announceToScreenReader(`${title} ${safeMessage.body.textContent.trim()}`);

            if (duration > 0) {
                setTimeout(() => {
                    console.log(`removing ${id} after ${duration}ms`);
                    this.entries.splice(this.entries.indexOf(id), 1);
                }, duration);
            }

            if (this.entries.length > 5) {
                this.entries.shift();
            }
        },
        dismiss(index) {
            this.entries.splice(index, 1);
        }
    });

    Alpine.data("toasty", () => ({
        entries: Alpine.store("toast").entries,
        dismiss() {
            Alpine.store("toast").dismiss(parseInt(this.$el.dataset.index));
        },
        hasEntries() {
            return this.entries.length > 0;
        }
    }));

    Alpine.data("page", () => ({
        get colorSchemeName() {
            return Alpine.store('colorScheme').name;
        }
    }));

    Alpine.data("header", () => ({
        scroll: {
            x: 0,
            y: 0,
        },
        showSidebar: false,
        showForm: false,
        historyChangeListener: null,
        pin: false,
        notTop: false,

        show(state) {
            this[state] = true;
            window.location.hash = `#${state}`;

            this.historyChangeListener = (e) => {
                if (!location.hash) {
                    this.hide(state);
                }
            };

            window.addEventListener("hashchange", this.historyChangeListener);
        },

        hide(state) {
            this[state] = false;
            history.replaceState(null, null, " ");
            window.removeEventListener("hashchange", this.historyChangeListener);
        },
        init() {
            this.update(this.scroll);

            window.addEventListener(
                "scroll",
                documentation_throttle(() => {
                    this.update(this.scroll);
                }, 250)
            );
        },

        update(prev) {
            this.scroll = {
                y: window.pageYOffset || document.documentElement.scrollTop,
                x: window.pageXOffset || document.documentElement.scrollLeft,
            };

            if (this.scroll.y > 0) {
                this.notTop = true;
            } else {
                this.notTop = false;
            }

            if (this.scroll.y > 100) {
                this.pin = true;
            }

            if (this.scroll.y < prev.y) {
                this.pin = false;
            }
        },

        showSearch() {
            this.$store.searchPanel.show();
        },

        headerClass() {
            return [this.notTop ? '' : ''];
        },

        colorSchemeToggle() {
            this.$store.colorScheme.toggle();
        },

        isLight() {
            return this.$store.colorScheme.name === 'light';
        },

        isDark() {
            return this.$store.colorScheme.name === 'dark';
        },

        handleMenuButtonClick() {
            return this.showSidebar ? this.hide('showSidebar') : this.show('showSidebar')
        },

        isSidebarVisible() {
            return this.showSidebar;
        },

        isSidebarHidden() {
            return !this.showSidebar;
        },

        handleSidebarWindowEscape(e) {
            if (e.key === 'Escape') {
                this.hide('showSidebar');
            }
        }
    }));

    Alpine.data("search", () => ({
        focused: false,
        debounceTimeout: null,
        results: [],
        state: 'idle',

        init() {
            this.handleFocused();

            this.$refs.input.addEventListener('input', (e) => {
                const query = e.target.value;
                const selectedPostTypes = ['post', 'page'];

                clearTimeout(this.debounceTimeout);

                if (e.target.value.length <= 2) {
                    this.results = [];
                    return;
                }

                this.debounceTimeout = setTimeout(() => {
                    var formData = new FormData();
                    formData.append('action', 'documentation_index_search');
                    formData.append('query', query);
                    formData.append('post_types', JSON.stringify(selectedPostTypes));

                    this.results = [];
                    this.state = 'searching'

                    fetch(documentationData.ajaxURL, {
                        method: 'POST',
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            this.state = 'searched'
                            this.results = data
                        })
                        .catch(error => {
                            this.state = 'searched'
                            console.error('Error:', error);
                        });
                }, 300);
            });

            this.$refs.input.addEventListener('focus', (e) => {
                this.focused = true
            });

            this.$refs.input.addEventListener('blur', (e) => {
                this.handleFocused();
            });
        },

        handleFocused() {
            if (this.$refs.input.value) {
                this.focused = true
            } else {
                this.focused = false
            }
        }
    }));


    Alpine.data("searchTrigger", () => ({
        get loading() {
            return Alpine.store('fastFuzzySearchPanel').loading;
        },

        showSearch() {
            Alpine.store('fastFuzzySearchPanel').show();
        },

        get isDisabled() {
            return this.loading ? 'disabled' : false;
        },

        get isLoading() {
            return this.loading;
        },

        get isNotLoading() {
            return !this.loading;
        }
    }));


    let titles = [];
    let paths = [];

    Alpine.data("searchPanel", (action, defaultValue) => ({
        resultsVisible: false,
        searchResults: [],
        activeResultIndex: 0,
        selected: null,
        paths: [],
        fuzzy: new uFuzzy(),

        async init() {
            this.$store.searchPanel.loading = true;
            this.activeResultIndex = 0;

            try {
                // Perform fetch request when the document is ready
                const response = await fetch(documentationData.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: action,
                        security: documentationData._wpnonce, // Nonce value, change it as needed
                    }),
                });

                if (response.ok) {
                    const data = await response.json();
                    titles = data.titles;
                    paths = data.paths;
                }

            } catch (error) {
                // Handle errors
                console.error('Error:', error);
            }


            this.$store.searchPanel.loading = false;

            this.$watch('activeResultIndex', () => {
                this.$root.querySelector(`#search-results a[data-index="${this.activeResultIndex}"]`)?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest',
                });
            })
        },

        searchDebounced() {
            if (this.$store.searchPanel.query.length < 2) {
                this.resultsVisible = false;
                this.searchResults = [];
                return;
            }

            this.resultsVisible = true;

            let indexes = this.fuzzy.filter(titles, this.$store.searchPanel.query);

            if (indexes) {
                this.searchResults = indexes.slice(0, 6).map((idx) => titles[idx]);
                this.paths = indexes.slice(0, 6).map((idx) => paths[idx]);
            };
        },

        selectResult(result) {
            const anchors = this.$root.querySelectorAll('#search-results > li > a');

            anchors[this.activeResultIndex].click();

            this.selected = result

            this.$store.searchPanel.hide();
        },

        handleArrowNavigation(event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (this.activeResultIndex < this.searchResults.length - 1) {
                    this.activeResultIndex++;
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (this.activeResultIndex > 0) {
                    this.activeResultIndex--;
                }
            }
        },


        isActive(index) {
            return index === this.activeResultIndex;
        },

        selectResultWithEnter() {
            const activeResult = this.searchResults[this.activeResultIndex];
            if (activeResult) {
                this.selectResult(activeResult);
                this.activeResultIndex = -1;
            } else {
                this.$refs.form.submit();
            }
        },

    }));

    Alpine.data("changelog", () => ({
        rawValue: '',
        jsonValue: [],

        init() {
            this.jsonValue = parseChangelog(this.$refs.textarea.value);

            console.log(this.jsonValue);
        }
    }));

    Alpine.data("docsCard", () => ({
        expanded: false,

        get liClass() {
            return this.expanded || parseInt(this.$el.dataset.index) < 5 ? 'block' : 'hidden'
        },

        isExpanded() {
            return this.expanded;
        },

        isNotExpanded() {
            return !this.expanded;
        },

        toggleExpanded() {
            this.expanded = !this.expanded;
        }
    }));

    Alpine.data("docsSidebarItem", () => ({
        expanded: false,

        get liClass() {
            return this.expanded ? 'block' : 'hidden'
        },

        isExpanded() {
            return this.expanded;
        },

        isNotExpanded() {
            return !this.expanded;
        },

        toggleExpanded() {
            this.expanded = !this.expanded;
        }
    }));

    Alpine.magic('clipboard', () => {
        if (!navigator.clipboard) {
            return
        }

        return subject => {
            navigator.clipboard.writeText(subject)
        }
    });

    Alpine.directive('embla', (el, { value, modifiers, expression }, { Alpine, effect, cleanup }) => {

        if (!value) {
            Alpine.bind(el, {
                "x-data": () => ({
                    embla: null,
                    activeIndex: 0,
                    canScrollNext: true,
                    canScrollPrev: true,

                    emblaPrev() {
                        this.embla?.scrollPrev();
                    },

                    emblaNext() {
                        this.embla?.scrollNext();
                    },
                }),
            });
        } else if (value === 'main') {
            const autplayDelay = modifierValue(modifiers, 'autoplay', false);
            const autoplayOpttions = {
                delay: parseInt(autplayDelay),
            }

            Alpine.bind(el, {
                "x-init"() {
                    const handleDisabledState = () => {
                        this.canScrollNext = this.embla.canScrollNext();
                        this.canScrollPrev = this.embla.canScrollPrev();
                    }

                    window.addEventListener("load", () => {
                        const plugins = [];

                        if (autplayDelay) {
                            plugins.push(EmblaCarouselAutoplay(autoplayOpttions));
                        }

                        this.embla = EmblaCarousel(el, {
                            loop: modifierValue(modifiers, 'loop', false) === '1' ? true : false,
                            align: modifierValue(modifiers, 'align', 'center')
                        }, plugins);

                        this.embla.on('select', () => {
                            this.activeIndex = this.embla.selectedScrollSnap();
                        });

                        this.embla.on('select', handleDisabledState);
                        this.embla.on('settle', handleDisabledState);
                        this.embla.on('init', handleDisabledState);
                        this.embla.on('scroll', handleDisabledState);
                        this.embla.on('resize', handleDisabledState);

                        window.addEventListener('keydown', (e) => {
                            if (e.key === 'ArrowLeft') {
                                this.embla.scrollPrev();
                            } else if (e.key === 'ArrowRight') {
                                this.embla.scrollNext();
                            }
                        })
                    });
                },
            });
        } else if (value === 'page') {
            Alpine.bind(el, {
                "x-on:click.prevent"() {
                    this.embla?.scrollTo(parseInt(expression))
                }
            });
        } else if (value === 'next') {
            Alpine.bind(el, {
                "x-on:click.prevent"(e) {
                    this.embla?.scrollNext();
                },
            });
        } else if (value === 'prev') {
            Alpine.bind(el, {
                "x-on:click.prevent"(e) {
                    this.embla?.scrollPrev();
                },
            });
        }

        return () => {
            embla.destroy();
        };
    });

    Alpine.directive('lazy-src', (el, { value }) => {
        const imgSrc = value;

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting || entry.intersectionRatio > 0) {
                        el.setAttribute('src', imgSrc);
                        observer.unobserve(el);
                    }
                });
            });

            observer.observe(el);
            el.setAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'); // Transparent base64 image
        } else {
            // Fallback for browsers that don't support Intersection Observer
            el.setAttribute('src', imgSrc);
        }
    });
});

jQuery(document).ready(() => {
    const $ = jQuery;
    const isMobile = window.matchMedia("(max-width: 767px)");

    $('#commentform').each((i, form) => {
        $(form).find('input:not([type="radio"]):not([type="checkbox"]):not([type="hidden"]):not([style="display: none;"]), select, textarea').each((i, input) => {
            const label = $(form).find(`label[for="${input.getAttribute('id')}"]`);

            input.addEventListener("invalid", function (event) {
                let message = '';

                if (event.target.value.length < 1) {
                    message = `${label.text().trim()} is required`;
                } else {
                    message = `${label.text().trim()} is invalid`;
                }

                if (isMobile.matches) {
                    input.setCustomValidity(message);
                    announceToScreenReader(message, 'alert', 100, true);
                } else {
                    input.setCustomValidity(message);
                }
            });

            input.addEventListener("input", function (event) {
                input.setCustomValidity("");
            });
        });
    });

    $('.documentation_pagination').each((i, pagination) => {
        $(pagination).find('a.prev.page-numbers').parent().addClass('prev-item');
        $(pagination).find('a.next.page-numbers').parent().addClass('next-item');
    });

    function handleDocsHeadings() {

        const handleTocAnchor = (entry) => {
            if (entry.target.id) {
                const targetElement = document.querySelector(`.documentation_toc a[href="#${entry.target.id}"]`);

                if (entry.isIntersecting) {
                    targetElement?.classList.add('active');
                } else {
                    targetElement?.classList.remove('active');
                }
            }
        };

        const handleIntersection = (entries, observer) => entries.forEach(entry => handleTocAnchor(entry));

        const observer = new IntersectionObserver(handleIntersection, { root: null, rootMargin: '0px', threshold: 0.75 });

        $('.single-docs .entry-content, .single-post .entry-content').find('h1, h2, h3, h4, h5, h6').each(function (i, heading) {
            if (!heading.hasAttribute('id')) {
                $(heading).attr('id', heading.textContent.trim().replace(/\s+/g, '-').toLowerCase());
            }

            observer.observe(heading)
        });
    }

    $('.comment-content').addClass('prose');

    window.addEventListener("hashchange", () => {
        const hash = window.location.hash;
        
        if (hash) {
            const element = document.querySelector(hash);
            if (element) {
                element.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        };
    });

    handleDesktopMenu();
    handleDocsHeadings();
});

function handleDesktopMenu() {
    const $ = jQuery;

    const menuItems = document.querySelectorAll('.menu-item');

    if (menuItems.length > 0) {
        menuItems.forEach((item) => {
            handleMenuItem(item);
        });
    }

    function handleMenuItem(item) {
        const anchor = item.querySelector('a');
        const toggle = item.querySelector('.menu-toggle');
        const submenu = item.querySelector('.sub-menu');

        if (!toggle || !submenu || !anchor) {
            return;
        }

        toggle.setAttribute('aria-label', `${anchor.textContent.trim()}`);

        toggle.addEventListener('click', () => {
            item.classList.toggle('toggled');
            toggle.setAttribute('aria-expanded', item.classList.contains('toggled'));
        });

        anchor.addEventListener('keydown', (e) => {
            if (e.key === 'Tab' && e.shiftKey) {
                item.classList.remove('toggled');
            }
        });

        handleSubMenu(item, submenu)
    }

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const item = e.target.closest('.toggled');

            if (!item) {
                return
            }

            const toggle = item.querySelector('.menu-toggle');

            item.classList.remove('toggled');

            if (toggle) {
                toggle.focus();
            }
        }
    });

    function handleSubMenu(item, menu) {
        const items = menu.querySelectorAll('.menu-item');
        const last = items[items.length - 1];
        const lastAnchor = last.querySelector('a');

        if (lastAnchor) {
            lastAnchor.addEventListener('keydown', (e) => {
                if (e.key === 'Tab' && !e.shiftKey) {
                    item.classList.remove('toggled');
                }
            });
        }
    }

}


function parseChangelog(inputString) {
    const lines = inputString.split('\n');
    const changelog = [];

    let currentVersion = null;

    for (let i = 0; i < lines.length; i++) {
        const line = lines[i].trim();

        if (line.startsWith('==') && line.endsWith('==')) {
            // Ignore section headers
            continue;
        } else if (line.startsWith('=') && line.endsWith('=')) {
            // Extract version and date
            const versionDateLine = line.substring(1, line.length - 1).trim().split(' ');
            const version = versionDateLine[0];
            const date = versionDateLine[1];

            // Create a new entry for this version
            currentVersion = {
                version: version,
                date: date,
                changes: []
            };
            changelog.push(currentVersion);
        } else if (line.startsWith('**') && line.endsWith('**') && currentVersion) {
            // Extract product name
            const productName = line.substring(2, line.length - 2).trim();
            currentVersion.product = productName;
        } else if (line.startsWith('*') && currentVersion) {
            // Extract category and log details
            const categoryEndIndex = line.indexOf(' - ');
            const category = line.substring(2, categoryEndIndex).trim();
            const logDetail = line.substring(categoryEndIndex + 3).trim();

            // Check if the category exists
            let categoryObj = currentVersion.changes.find(item => item.name === category);
            if (!categoryObj) {
                categoryObj = {
                    name: category,
                    log: []
                };
                currentVersion.changes.push(categoryObj);
            }

            // Extract log details
            const logDetailParts = /(.+)\[#(\d+)\]/.exec(logDetail);
            if (logDetailParts && logDetailParts.length === 3) {
                const description = logDetailParts[1].trim();
                const id = logDetailParts[2].trim();
                categoryObj.log.push({ description, id });
            }
        }
    }

    return changelog;
}


let liveElementTimeout = null;

function announceToScreenReader(text, role, timeout = 1000, once = false) {
    if (once && liveElementTimeout) {
        return;
    }

    const liveElement = document.querySelector(".live-status-region");
    const paraElement = document.createElement("p");
    const textElement = document.createTextNode(text);

    if (!liveElement) {
        return;
    }

    liveElement.setAttribute("role", role === undefined ? "status" : role);
    paraElement.appendChild(textElement);
    liveElement.appendChild(paraElement);

    liveElementTimeout = setTimeout(() => {
        liveElement.innerHTML = "";
        liveElement.setAttribute("role", "status");
        liveElementTimeout = null;
    }, timeout);
}

function documentation_throttle(func) {
    let queued = false;

    return function (...args) {
        if (!queued) {
            queued = true;
            requestAnimationFrame(() => {
                func.apply(this, args);
                queued = false;
            });
        }
    };
}
function modifierValue(modifiers, key, fallback) {
    if (modifiers.indexOf(key) === -1) return fallback;

    const rawValue = modifiers[modifiers.indexOf(key) + 1];

    if (!rawValue) return fallback;

    return rawValue;
}

function randomId(length = 10) {
    const possibleCharacters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    const possibleCharacterArray = Array.from(possibleCharacters);
    const resultArray = [];

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * possibleCharacterArray.length);
        const randomCharacter = possibleCharacterArray[randomIndex];
        resultArray.push(randomCharacter);
    }

    return resultArray.join('');
}
