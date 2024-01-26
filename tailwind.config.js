/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
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
        extend: {},
    },
    plugins: [],
}
