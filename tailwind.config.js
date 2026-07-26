import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

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
                // Loaded-style deep navy / indigo storefront palette
                navy: {
                    50: '#eeeefb',
                    100: '#d9d9f5',
                    200: '#b4b4ea',
                    300: '#8a8adb',
                    400: '#6262c9',
                    500: '#4444ad',
                    600: '#343473',
                    700: '#2b2b63',
                    800: '#20204d',
                    850: '#1a1a44',
                    900: '#161638',
                    950: '#10102a',
                },
                brand: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                // Green "BUY" accent
                grass: {
                    400: '#4ade80',
                    500: '#2fbf71',
                    600: '#25a862',
                    700: '#1f8f53',
                },
                // Cyan utility-strip accent
                aqua: {
                    400: '#4dd4e0',
                    500: '#38bccb',
                },
            },
        },
    },

    plugins: [forms],
};
