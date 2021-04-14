const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {

        extend: {

            colors: {
                'brand-blue': '#bcbcbc', //custom collor-> later we used with class 'text-brand-blue'
            },
            spacing: {
                '72': '18rem',
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            height: {
                '90': 'calc(100% - 90px)',
                '165': 'calc(100% - 165px)',
                'screen-minus-100': 'calc(100vh - 100px)',
                'screen-minus-70': 'calc(100vh - 70px)',
            },
            minWidth: {
                '10': '2.5rem',
                '8': '2rem',
                '16': '4rem',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
        backgroundColor: ['responsive', 'hover', 'focus', 'active'],
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
