/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./modules/**/*.{html,js,php}", "./public/**/*.{html,js,php}", "./includes/**/*.{html,js,php}"],
    theme: {
        extend: {
            fontFamily: {
                'chillax': ['Chillax', 'sans-serif'],
                'supreme': ['Supreme', 'sans-serif'],
            },
            colors: {
                'primary': '#4CB05C',
            },
        },
    },
    safelist: ["alert-error", "alert-info", "alert-warning.svg", "alert-success"],
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    "primary": "#4CB05C",
                    "secondary": "#f6d860",
                    "accent": "#37cdbe",
                    "neutral": "#3d4451",
                    "base-100": "#ffffff",
                    "base-200": "#f9fafb",
                    "base-300": "#f3f4f6",
                },
            },
        ],
    },
};
