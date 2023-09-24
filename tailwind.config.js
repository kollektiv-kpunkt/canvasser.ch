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
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "accent": {
                    150: "#802E29",
                    140: "#993731",
                    130: "#B24039",
                    120: "#CC4941",
                    110: "#E55249",
                    DEFAULT: "#FF5B51",
                    90: "#FF6B62",
                    80: "#FF7C74",
                    70: "#FF8C85",
                    60: "#FF9D97",
                    50: "#FFADA8",
                    40: "#FFBDB9",
                    30: "#FFCECB",
                    20: "#FFDEDC",
                    10: "#FFEFEE",
                    "slight": "#FFF7F6"
                },
                "secondary": {
                    150: "#250A48",
                    140: "#2C0B56",
                    130: "#330D64",
                    120: "#3A0F72",
                    110: "#421181",
                    DEFAULT: "#49138F",
                    90: "#5B2B9A",
                    80: "#6D42A5",
                    70: "#805AB1",
                    60: "#9271BC",
                    50: "#A489C7",
                    40: "#B6A1D2",
                    30: "#C8B8DD",
                    20: "#DBD0E9",
                    10: "#EDE7F4",
                    "slight": "#F6F3F9"
                }
            }
        },
    },

    plugins: [forms, require('tailwindcss-font-inter')],
};
