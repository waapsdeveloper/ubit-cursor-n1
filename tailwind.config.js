import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'ubit-purple': {
                    500: '#6449E7',
                    600: '#7C5CF5',
                    700: '#5A3FD8',
                },
                'ubit-yellow': {
                    300: '#FDE047',
                    400: '#FACC15',
                }
            },
        },
    },

    plugins: [forms],
};
