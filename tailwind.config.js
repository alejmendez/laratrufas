/** @type {import('tailwindcss').Config} */
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
    extend: {
    },
  },
  plugins: [],
}
