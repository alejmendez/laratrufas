/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')

export default {
  darkMode: ['class'],
  safelist: ['dark'],
  prefix: '',

  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{js,jsx,vue}',
  ],

  theme: {
    screens: {
      ...defaultTheme.screens,
      'sm': '375px',
    },
  },
  plugins: [],
}
