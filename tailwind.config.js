import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Figtree', ...defaultTheme.fontFamily.sans],
                mono: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand accent: buttons, links, highlights
                primary: {
                    DEFAULT: '#2547D0',
                    dark: '#1C37A8',   // hover / pressed
                    soft: '#E8EDFC',   // tinted backgrounds, icon chips
                },
                // Ink: headings and body text
                secondary: {
                    DEFAULT: '#212845',
                    muted: '#5B6280',  // paragraphs, captions
                },
                // Neutrals
                canvas: '#F7F8FB',     // page background
                surface: '#FFFFFF',    // cards, inputs
                line: '#E4E7EF',       // borders, dividers
            },
            boxShadow: {
                card: '0 1px 2px rgba(33, 40, 69, 0.04), 0 8px 24px rgba(33, 40, 69, 0.06)',
            },
            borderRadius: {
                xl: '0.875rem',
                '2xl': '1.25rem',
            },
        },
    },
    plugins: [],
};
