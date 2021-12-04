const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    mode: 'jit',

    darkMode: 'media',

    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                gray: colors.warmGray,
                primary: colors.amber,
            },
            //
        },
        container: {
            center: true,
            padding: '1rem',
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
    ],
};
