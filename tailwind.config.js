/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./templates/**/*.templ",
    ],
    theme: {
        container: {
            screens: {
                sm: '540px',
                md: '768px',
                lg: '960px',
                xl: '960px',
            },
        },
        extend: {
        },
    },
    plugins: [],
}

