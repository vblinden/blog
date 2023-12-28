const defaultTheme = require('tailwindcss/defaultTheme')

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
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
}

