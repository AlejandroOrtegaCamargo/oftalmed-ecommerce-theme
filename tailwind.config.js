/** @type {import('tailwindcss').Config} */
module.exports = {
  // 1. CONTENT: Cubrimos ambas posibilidades (rutas absolutas y relativas)
  content: [
    './**/*.php', // Escanea todo si el config está dentro de astra-child
    './assets/js/**/*.js', // La ruta correcta para tu JS
    './astra-child/**/*.php', // Por si ejecutas el compilador desde la raíz de WP
    './astra-child/assets/js/**/*.js',
  ],
  
  // 🚀 EL TRUCO INFALIBLE: Safelist
  // Esto obliga a Tailwind a compilar estas clases aunque no las encuentre en los archivos
  safelist: [
    'bg-text-heading/40',
    'bg-text-heading',
    'border-surface-ash',
    'text-text-heading',
    'bg-surface-default',
    'bg-surface-muted',
    'text-text-body'
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Montserrat', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        brand: {
          primary: '#145BC4',
          accent: '#019DFB',
          hover: '#22ACFF',
          light: '#E6F5FF',
          dark: '#007BB5',
        },
        surface: {
          default: '#ffffff',
          muted: '#f9fafb',
          ash: '#d1d5db',
          line: '#f3f4f6',
        },
        text: {
          heading: '#111827',
          body: '#374151',
          muted: '#6c757d',
        },
        ui: {
          success: { bg: '#f0fdf4', border: '#bbf7d0', text: '#166534' },
          error: { bg: '#fef2f2', border: '#fecaca', text: '#991b1b' },
          info: { bg: '#eff6ff', border: '#bfdbfe', text: '#1e3a8a' },
        }
      },
      boxShadow: {
        'bento': '0 5px 15px rgba(0, 0, 0, 0.12)',         
        'bento-hover': '0 10px 25px rgba(0, 0, 0, 0.2)',  
        'btn': '0 4px 10px rgba(1, 157, 251, 0.15)',        
        'btn-hover': '0 8px 20px rgba(1, 157, 251, 0.2)',  
      },
      borderRadius: {
        'bento': '1.5rem',     
        'btn': '0.75rem',      
        'input': '0.5rem',     
        'pill': '9999px',      
      },
      letterSpacing: {
        'widest-xl': '0.2em',  
      }
    },
  },
  plugins: [],
}