import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/masmerise/livewire-toaster/resources/views/*.blade.php",
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

                // "0%": {
                //     opacity: "0",
                //     transform: "translateY(100%)",
                //     maxWidth: "fit-content",
                // },
                // "20%": {
                //     opacity: "1",
                //     transform: "translateY(0)",
                //     maxWidth: "fit-content",
                // },
                // "80%": {
                //     opacity: "1",
                //     transform: "translateY(0)",
                //     maxWidth: "fit-content",
                // },
                // "100%": {
                //     opacity: "0",
                //     transform: "translateY(0)",
                //     maxWidth: "0",
                // },
            },
        },
        animation: {
            toasts: "toasts 3s forwards", // 1s delay + 1s transition
        },
    },

    plugins: [forms],
};
