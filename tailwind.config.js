/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./woocommerce/**/*.php"
  ],
  theme: {
    extend: {
      fontFamily: {
        // Montserrat como fuente principal sans
        sans: ['Montserrat', 'sans-serif'],
      },
      colors: {
        // Estructura corregida para usar bg-brand-primary o text-brand-secondary
        'brand-primary': '#145BC4',
        'brand-secondary': '#019DFB',
      },
    },
  },
  plugins: [],
}