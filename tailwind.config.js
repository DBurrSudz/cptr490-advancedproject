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
            'dark-blue': {
                DEFAULT: '#022D4D'
            },
            yellow: {
                DEFAULT: '#FFD703'
            },
            white: "#FFFFFF"
        }
    },

    variants: {
        border: ['focus'],
    },

    plugins: [require('@tailwindcss/forms')],
};
