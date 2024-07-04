import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        ,
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            backgroundColor: ["even"],
        },
        keyframes: {
            toasts: {
                "0%": { opacity: "0", transform: "translateY(100%)" },
                "20%": { opacity: "1", transform: "translateY(0)" },
                "80%": { opacity: "1", transform: "translateY(0)" },
                "100%": {
                    opacity: "0",
                    transform: "translateY(0)",
                },
            },
        },
        animation: {
            toasts: "toasts 5s forwards", // 1s delay + 1s transition
        },
    },

    plugins: [forms],
};
