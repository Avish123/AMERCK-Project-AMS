/** @type {import('tailwindcss').Config} */
import daisyui from 'daisyui';
export default {
    content: [
        // You will probably also need these lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],
    theme: {
        extend: {},
    },

    // Add daisyUI
    plugins: [daisyui],
    daisyui: {
        themes: ["emerald"],
    },
};
