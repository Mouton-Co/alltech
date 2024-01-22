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
                orangehover: '#df641fc7',
                black: '#1f1f1f',
                darkgray: '#555555',
                gray: '#e5e5e5',
                lightgray: '#f7f7f7',
                nothing: '#f3f3f3',
                torquise: '#424b4e',
                lightblue: '#4c6b77',
                blue: '#2f80ed',
                'gray-50': 'rgb(249 250 251)',
                'gray-100': 'rgb(243 244 246)',
                'gray-200': 'rgb(229 231 235)',
                'gray-300': 'rgb(209 213 219)',
                'gray-400': 'rgb(156 163 175)',
                'gray-500': 'rgb(107 114 128)',
                'gray-600': 'rgb(75 85 99)',
                'gray-700': 'rgb(55 65 81)',
                'gray-800': 'rgb(31 41 55)',
                'gray-900': 'rgb(17 24 39)',
            },
            boxShadow: {
                solidlightblue: '0 0 0 28px #4c6b77',
                solidnothing: '0 0 0 38px #f3f3f3',
                inner: 'inset 0px 2px 6px #575757',
            },
            borderRadius: {
                'pill': '50vw',
            },
            zIndex: {
                '60': 60,
            }
        },
        screens: {
            'smaller-than-380': {'min': '0px', 'max': '380px'},
            'smaller-than-520': {'min': '0px', 'max': '520px'},
            'smaller-than-740': {'min': '0px', 'max': '740px'},
            'smaller-than-928': {'min': '0px', 'max': '928px'},
            ...defaultTheme.screens,
        },
    },

    safelist: [
        'bg-green-100',
        'bg-green-200',
        'b-green-500',
        'text-green-500',
        'text-green-700',
        'ring-green-400',
        'bg-red-100',
        'bg-red-200',
        'b-red-500',
        'text-red-500',
        'text-red-700',
        'ring-red-400',
    ],

    plugins: [
        forms,
        require('flowbite/plugin')
    ],

    darkMode: 'class',
};
