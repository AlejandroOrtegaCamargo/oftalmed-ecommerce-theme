/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./woocommerce/**/*.php"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          primary: '#145BC4',   /* Tu azul principal */
          secondary: '#019DFB', /* Tu azul para los hover/botones */
        },
      },
    },
  },
  plugins: [],
}
