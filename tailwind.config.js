import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
    ],

    safelist: [
        'bg-blue-100',
        'bg-green-100',
        'bg-purple-100',
        'bg-orange-100',
        'bg-[#ebf8ff]',
        'text-[#0059FF]',
        'text-[#10AF13]',
        'text-[#AE00FF]',
        'text-[#FF4D00]',
        'text-[#5EABD6]',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
