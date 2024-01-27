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

    $('.wpj-jtoc').each((i, toc) => {
        const toggle = $(toc).find('.wpj-jtoc--toggle');
        const label = $(toc).find('.wpj-jtoc--title-label');

        label.attr({
            'role': 'heading',
            'aria-level': 2,
        });

        toggle.attr({
            'role': 'button',
            'tabindex': 0,
            'aria-label': `${label.text().trim()} Toggle`,
            'aria-expanded': toc.classList.contains('--jtoc-is-unfolded'),
        });

        toggle.on('click', () => {
            toggle.attr('aria-expanded', !toc.classList.contains('--jtoc-is-unfolded'));
        })
    });

    $('.flipcard').each((i, flipcard) => {
        const buttons = flipcard.querySelectorAll('.flipcard__button');
        const front = flipcard.querySelector('.flipcard__front');
        const back = flipcard.querySelector('.flipcard__back');

        if (buttons.length < 1) {
            return
        }

        back.setAttribute('aria-hidden', true);
        $(back).find('a, button').attr('tabindex', -1);

        function handleChange() {
            if (flipcard.classList.contains('flipped')) {
                front.setAttribute('aria-hidden', true);
                back.removeAttribute('aria-hidden');

                $(back).find('a, button').removeAttr('tabindex');
                $(front).find('a, button').attr('tabindex', -1);

                const flipToBackButton = $(flipcard).find('.flipcard__button--back');

                flipToBackButton.focus();

                announceToScreenReader(`${flipToBackButton.attr('aria-label')}`);
            } else {
                back.setAttribute('aria-hidden', true);
                front.removeAttribute('aria-hidden');

                $(front).find('a, button').removeAttr('tabindex');
                $(back).find('a, button').attr('tabindex', -1);

                const flipToFrontButton = $(flipcard).find('.flipcard__button--front');

                flipToFrontButton.focus();

                announceToScreenReader(`${flipToFrontButton.attr('aria-label')}`);
            }
        }

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                flipcard.classList.toggle('flipped');
                handleChange();
            });
        });
    });

    $('.footer__form').each((i, form) => {
        $(form).find('.forminator-email--field').each((i, input) => {
            const placeholder = $(input).attr('placeholder');
            const label = $(input).prev('label');

            if (input.value === '') {
                label.removeClass('floating');
            }

            $(input).removeAttr('placeholder');

            $(input).on('mouseenter focus', () => {
                label.addClass('floating');
                $(input).attr('placeholder', placeholder);
            });

            $(input).on('mouseleave blur', (e) => {
                if (e.target.value === '') {
                    label.removeClass('floating');
                    $(input).removeAttr('placeholder');
                }
            });

            $(input).on('input change', (e) => {
                if (document.activeElement !== e.target && e.target.value === '') {
                    label.removeClass('floating');
                    $(input).removeAttr('placeholder');
                }
            });
        })
    });


    function handleDocsHeadings() {

        const handleTocAnchor = (hash) => {
            if (hash) {
                const currentActive = document.querySelector(`.documentation_toc a.active`);
                const targetElement = document.querySelector(`.documentation_toc a[href="#${hash}"]`);

                if (currentActive) {
                    currentActive.classList.remove('active');
                }

                if (targetElement) {
                    targetElement.classList.add('active'); // Add your desired class
                }
            }
        };

        const updateHash = entry => {
            if (entry.isIntersecting) {
                handleTocAnchor(entry.target.id)
            }
        };

        const handleIntersection = (entries, observer) => entries.forEach(entry => updateHash(entry));

        const observer = new IntersectionObserver(handleIntersection, { root: null, rootMargin: '0px', threshold: 0.5 });

        $('.single-docs .entry-content').find('h1, h2, h3, h4, h5, h6').each(function (i, heading) {
            observer.observe(heading)
        });
    }

    handleDesktopMenu();
    handleEmbla();
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

function handleEmbla() {
    const OPTIONS = {};

    const node = document.querySelector('.embla');

    if (!node) {
        return
    }

    const viewport = node.querySelector('.embla__viewport');
    const prev = node.querySelector('.embla__prev');
    const next = node.querySelector('.embla__next');

    const embla = EmblaCarousel(viewport, OPTIONS);

    embla.on('select', () => {
        handleNavState();
    });

    embla.on('init', () => {
        handleNavState();
    });

    function handleNavState() {
        if (prev) {
            if (embla.canScrollPrev()) {
                prev.removeAttribute('disabled');
            } else {
                prev.setAttribute('disabled', 'disabled');
            }
        }

        if (next) {
            if (embla.canScrollNext()) {
                next.removeAttribute('disabled');
            } else {
                next.setAttribute('disabled', 'disabled');
            }
        }
    }

    function handleSlideChangeAnnouncement() {
        announceToScreenReader(`You are on slide ${embla.selectedScrollSnap() + 1}/${embla.internalEngine().slideIndexes.length}`)
    }

    if (prev) {
        prev.addEventListener('click', (e) => {
            embla.scrollPrev();
            handleSlideChangeAnnouncement();
        });
    }

    if (next) {
        next.addEventListener('click', (e) => {
            embla.scrollNext();
            handleSlideChangeAnnouncement();
        });
    }
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


document.addEventListener("alpine:init", () => {
    Alpine.store('searchPanel', {
        isVisible: false,

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

            if(window.matchMedia('(prefers-color-scheme: dark)').matches) {
                this.name = 'dark'
            }

            if(fromStorage) {
                this.name = fromStorage
            }
        },

        set(value) {
            if (!['light', 'dark'].includes(value)) {
                return
            };

            this.name = value
            localStorage.setItem('colorScheme',  this.name);
        },

        toggle() {
            if(this.name == 'light') {
                this.set('dark');
            } else {
                this.set('light');
            }
        }
    });

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
                throttle(() => {
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
                    this.results = []
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

    let titles = [];
    let paths = [];

    Alpine.data("searchPanel", (action, defaultValue) => ({
        search: defaultValue || '',
        resultsVisible: false,
        searchResults: [],
        activeResultIndex: -1,
        selected: null,
        paths: [],
        fuzzy: new uFuzzy(),
        initiating: false,

        async init() {
            this.initiating = true;

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


            this.initiating = false;
        },

        searchDebounced() {
            if (this.search.length < 2) {
                this.resultsVisible = false;
                this.searchResults = [];
                return;
            }

            this.resultsVisible = true;

            let indexes = this.fuzzy.filter(titles, this.search);

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

    Alpine.magic('clipboard', () => {
        if (!navigator.clipboard) {
            return
        }

        const toast = new Toast();

        return subject => {
            toast
                .setMessage('Link copied to the clipboard')
                .setDuration(200000)
                .setDismissButton(true)
                .setPosition('bottom-right')
                .show();

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

function throttle(func) {
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
