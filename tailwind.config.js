/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        'outfit': ['Outfit', 'sans-serif'],
      },
      colors: {
        'canvas': '#F0F0F0',
        'foreground': '#121212',
        'bauhaus-red': '#D02020',
        'bauhaus-blue': '#1040C0',
        'bauhaus-yellow': '#F0C020',
        'bauhaus-black': '#121212',
      },
      boxShadow: {
        'bauhaus-sm': '3px 3px 0px 0px rgba(18, 18, 18, 1)',
        'bauhaus': '4px 4px 0px 0px rgba(18, 18, 18, 1)',
        'bauhaus-md': '6px 6px 0px 0px rgba(18, 18, 18, 1)',
        'bauhaus-lg': '8px 8px 0px 0px rgba(18, 18, 18, 1)',
      },
      letterSpacing: {
        'tighter': '-0.05em',
        'tight': '-0.025em',
        'normal': '0em',
        'wide': '0.025em',
        'wider': '0.05em',
        'widest': '0.1em',
      },
      lineHeight: {
        'tight': '0.9',
        'snug': '1.2',
        'normal': '1.5',
        'relaxed': '1.75',
      },
    },
  },
  plugins: [],
}
