import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            keyframes: {
                entrance: {
                    "0%": { transform: "translateX(-100%)", opacity: 0 },
                    "50%": { transform: "translateX(10px)", opacity: 0.5 },
                    "100%": { transform: "translateX(0)", opacity: 1 },
                },
            },
            animation: {
                entrance: "entrance 1s ease-in-out",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
