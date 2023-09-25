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
                black: '#231f20',
                bg_gray: '#1d2125',
                bg_darkgray: '#161a1d',
                bg_lightgray: '#22272b',
                bg_seperator: '#282e35',
            },
            boxShadow: {
                sidebar: '#e5e7eb 2px 1.5px 3px',
            },
            
        },
    },

    safelist: [
        'border-green-500',
        'text-green-500',
        'text-green-700',
        'bg-green-100',
        'bg-green-200',
        'ring-green-400',
        'border-red-500',
        'text-red-500',
        'text-red-700',
        'bg-red-100',
        'bg-red-200',
        'ring-red-400',
    ],

    plugins: [
        forms,
        require('flowbite/plugin')
    ],

    darkMode: 'class',
};
