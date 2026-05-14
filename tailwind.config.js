/** @type {import('tailwindcss').Config} */
module.exports = {
  // 1. CONTENT: Rutas corregidas para apuntar dentro de tu tema hijo
  content: [
    './astra-child/**/*.php',            // Escanea todos los PHP en astra-child y sus subcarpetas
    './astra-child/woocommerce/**/*.php', // (Opcional pero recomendado por seguridad)
    './astra-child/inc/**/*.php',
    './astra-child/assets/js/**/*.js',
    // Mantenemos esta por si acaso tienes algún index.php suelto en la raíz
    './*.php', 
  ],
  theme: {
    extend: {
      // INYECTADO: Aseguramos que font-sans use Montserrat por defecto
      fontFamily: {
        sans: ['Montserrat', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      // 2. DESIGN TOKENS: Colores Semánticos
      colors: {
        brand: {
          primary: '#145BC4', // Azul Oftalmed Oscuro (Titulares y elementos de marca)
          accent: '#019DFB',  // Azul CTA (Botones de compra)
          hover: '#22ACFF',   // Hover de botones
          light: '#E6F5FF',   // Fondos sutiles
          dark: '#007BB5',    // Para estados activos
        },
        surface: {
          default: '#ffffff', // Fondo de Bento Boxes
          muted: '#f9fafb',   // Fondos secundarios (gray-50)
          ash: '#d1d5db',
          line: '#f3f4f6',    // Divisores y bordes sutiles (gray-100)
        },
        text: {
          heading: '#111827', // text-gray-900 (Títulos)
          body: '#374151',    // text-gray-700 (Textos base)
          muted: '#9ca3af',   // text-gray-400 (Precios c/u, subtítulos)
        },
        // Colores para el wc_print_notices()
        ui: {
          success: { bg: '#f0fdf4', border: '#bbf7d0', text: '#166534' }, // green
          error: { bg: '#fef2f2', border: '#fecaca', text: '#991b1b' },   // red
          info: { bg: '#eff6ff', border: '#bfdbfe', text: '#1e3a8a' },    // blue
        }
      },
      
      // 3. DESIGN TOKENS: Sombras y Profundidad (Elevation)
      boxShadow: {
        'bento': '0 20px 40px rgba(0, 0, 0, 0.1)',         
        'bento-hover': '0 25px 50px rgba(0, 0, 0, 0.15)',  
        'btn': '0 4px 10px rgba(1, 157, 251, 0.1)',        
        'btn-hover': '0 8px 20px rgba(1, 157, 251, 0.2)',  
      },

      // 4. DESIGN TOKENS: Radios de borde (Border Radius)
      borderRadius: {
        'bento': '1.5rem',     // rounded-3xl
        'btn': '0.75rem',      // rounded-xl
        'input': '0.5rem',     // rounded-lg
        'pill': '9999px',      // Botones tipo "Eliminar"
      },

      // 5. DESIGN TOKENS: Tipografía (Ajustes finos)
      letterSpacing: {
        'widest-xl': '0.2em',  
      }
    },
  },
  plugins: [],
}