/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "admin-primary": "#3b82f6",
                "admin-secondary": "#1e40af",
            },
        },
    },
    plugins: [require("daisyui")],
};
