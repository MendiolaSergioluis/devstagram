/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    // Código añadido a continuación
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
    // Fin de la modificación
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
