import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/**/**/*.blade.php",
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                orange: '#de6320',
                black: '#1f1f1f',
                darkgray: '#555555',
                gray: '#e5e5e5',
                nothing: '#f3f3f3',
                torquise: '#424b4e',
                lightblue: '#4c6b77',
            },
            boxShadow: {
                solidlightblue: '0 0 0 28px #4c6b77',
                solidnothing: '0 0 0 38px #f3f3f3',
                inner: 'inset 0px 2px 6px #575757',
            },
            borderRadius: {
                'pill': '50vw',
            },
        },
        screens: {
            'smaller-than-380': {'min': '0px', 'max': '380px'},
            ...defaultTheme.screens,
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],

    darkMode: 'class',
};
