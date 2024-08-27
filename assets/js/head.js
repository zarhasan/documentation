twind.install({
    hash: false,
    variants: [
        ['when-sm', '@media screen and (max-width: 768px)'],
        ['when-md', '@media screen and (max-width: 1024px)'],
        ['children', '& > *'],
        ['expanded', '&[aria-expanded="true"]'],
        ['focused', '.focused &'],
        ["selected", '&[aria-selected="true"]'],
        ["current", '&[aria-current="true"], &[aria-current="page"]'],
        ["scrolled", "&.scrolled"],
        ["admin-bar", ".admin-bar &"],
        ["touch", "@media (hover: none)"],
    ],
    theme: {
        fontFamily: {
            primary: [
                "Open Sans",
                "-apple-system",
                "BlinkMacSystemFont",
                "Segoe UI",
                "Roboto",
                "Oxygen",
                "Ubuntu",
                "Cantarell",
                "Fira Sans",
                "Droid Sans",
                "Helvetica Neue",
                "sans-serif",
            ],
        },
        container: {
            center: true,
            padding: {
                "DEFAULT": "1.5rem",
                "sm": "1.5rem",
                "md": "2.5rem",
                "lg": "2.5rem",
                "xl": "2.5rem",
                "2xl": "5vw",
            }
        },
        extend: {
            colors: {
                "primary": "var(--color-primary)",
                "primary-50": "var(--color-primary-50)",
                "primary-100": "var(--color-primary-100)",
                "primary-300": "var(--color-primary-300)",
                "primary-800": "var(--color-primary-800)",
                "primary-foreground": "var(--color-primary-foreground)",
                gray: {
                    0: 'var(--color-gray-0)',
                    50: 'var(--color-gray-50)',
                    100: 'var(--color-gray-100)',
                    200: 'var(--color-gray-200)',
                    300: 'var(--color-gray-300)',
                    400: 'var(--color-gray-400)',
                    600: 'var(--color-gray-600)',
                    700: 'var(--color-gray-700)',
                    800: 'var(--color-gray-800)',
                    900: 'var(--color-gray-900)',
                    1000: 'var(--color-gray-1000)',
                }
            },
            spacing: {
                "112": "28rem",
                "128": "32rem",
                "136": "34rem",
                "144": "36rem",
                "152": "38rem",
                "168": "42rem",
            },
            transitionTimingFunction: {
                'in-expo': 'cubic-bezier(0.95, 0.05, 0.795, 0.035)',
                'out-expo': 'cubic-bezier(0.19, 1, 0.22, 1)',
            },
            transitionDuration: {
                '400': '400ms',
            }
        },
    },
});
