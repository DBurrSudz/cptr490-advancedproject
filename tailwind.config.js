const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                red: {
                    DEFAULT: '#F3451E',
                },
                green: {
                    DEFAULT: '#4CAF50'
                },
                gray: {
                    DEFAULT: '#ECECEC'
                },
                'dark-blue': {
                    DEFAULT: '#022D4D'
                },
                'faint-blue': {
                    DEFAULT: '#617F95'
                },
                yellow: {
                    DEFAULT: '#FFD703'
                },
                white: "#FFFFFF",
                'cool-gray-600': {
                    DEFAULT: '#4b5563 '
                },
                'amber-600': {
                    DEFAULT: '#d97706 '
                },
                'indigo-700': {
                    DEFAULT: '#4338ca '
                },
                'rose-600': {
                    DEFAULT: '#e11d48 '
                }

            }
        },

    },

    variants: {
        border: ['focus'],
    },

    plugins: [require('@tailwindcss/forms')],
};
