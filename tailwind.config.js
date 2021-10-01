const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  stats: {
    children: true,
  },
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#FFC233',
                    light: '#FFF538',
                    dark: '#C19A32',
                    green: '#8c9878'
                },
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography'), 
        require('@tailwindcss/custom-forms'),
    ],
};    






