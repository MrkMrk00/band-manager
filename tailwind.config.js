/** @type {import('tailwindcss').Config} */
export default {
    content: ['./resources/**/*.{ts,tsx,js,jsx,blade.php}'],
    theme: {
        extend: {
            colors: {
                accent: '#0ea5e9',
            },
        },
    },
    plugins: [],
};
