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
                sans: ['Quicksand', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            fontWeight: {
                normal: 500,
                medium: 500,
                semibold: 600,
                bold: 700,
            },
        },
    },

    plugins: [forms],
};
