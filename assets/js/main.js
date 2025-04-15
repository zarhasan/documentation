document.addEventListener("alpine:init", () => {
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

    Alpine.data("docsCard", () => ({
        expanded: false,

        get isListItemVisible() {
            return this.expanded || parseInt(this.$el.dataset.index) < 5;
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

        init() {
            return this.$root.dataset.isCurrent === 'true' ? this.expanded = true : this.expanded = false;
        },

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

    Alpine.data("docsOverlays", () => ({
        showSidebar: false,
        showToc: false,

        toggleSidebar() {
            this.showSidebar = !this.showSidebar;
        },

        toggleToc() {
            this.showToc = !this.showToc;
        },

        hideSidebar() {
            this.showSidebar = false;
        },

        hideToc() {
            this.showToc = false;
        },

        isSidebar() {
            return this.showSidebar;
        },

        isNotSidebar() {
            return !this.showSidebar;
        },

        isToc() {
            return this.showToc;
        },

        isNotToc() {
            return !this.showToc;
        },

        sidebarClass() {
            return { 'translate-x-[22.5rem] z-[1501]': this.showSidebar }
        },

        tocClass() {
            return { '-translate-x-[22.5rem] z-[1501]': this.showToc }
        }
    }));


    Alpine.data("faq", () => ({
        activeIndex: null,

        handleWindowEscape(e) {
            if (e.key === 'ArrowDown') {
                this.activeIndex = (this.activeIndex + 1) % 3;
            } else if (e.key === 'ArrowUp') {
                this.activeIndex = (this.activeIndex + 3 - 1) % 3;
            }
        },

        isActive() {
            return this.activeIndex === parseInt(this.$el.closest('div[data-active-index]').dataset.activeIndex);
        },

        isNotActive() {
            return !this.isActive();
        },

        handleClick() {
            this.activeIndex = this.activeIndex === parseInt(this.$el.closest('div[data-active-index]').dataset.activeIndex) ? null : parseInt(this.$el.closest('div[data-active-index]').dataset.activeIndex)
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
                const targetElements = document.querySelectorAll(`.documentation_toc a[href="#${entry.target.id}"]`);

                if (entry.isIntersecting) {
                    targetElements.forEach(targetElement => {
                        targetElement.classList.add('active');
                    });
                } else {
                    targetElements.forEach(targetElement => {
                        targetElement.classList.remove('active');
                    });
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
