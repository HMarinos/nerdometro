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
                animecolor: colors.red[600],
                moviecolor: colors.blue[600],
                gamecolor: colors.yellow[600],
            },
            backgroundImage: {
                customgrad: "linear-gradient(45deg, #dc2626, #2563eb, #ca8a04)",
            },
        },
    },

    plugins: [forms],
};
