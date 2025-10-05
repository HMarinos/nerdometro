import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Quicksand", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            fontWeight: {
                normal: 500,
                medium: 500,
                semibold: 600,
                bold: 700,
            },
            colors: {
                animecolor: colors.rose[600],
                moviecolor: colors.violet[600],
                gamecolor: colors.teal[600],
            },
            backgroundImage: {
                customgrad: "linear-gradient(45deg, #e11d48, #7c3aed, #0d9488)",
            },
        },
    },

    plugins: [forms],
};
