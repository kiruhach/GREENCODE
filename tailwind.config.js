/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'green-dark': '#004524',
        'green-light': '#A8E4A0',
        'green-accent': '#44944A',
        'green-accent-light': '#92FFAD',
        'green-muted': 'rgba(255, 254.99, 254.98, 0.56)',
      },
      fontFamily: {
        'space': ['Space Grotesk', 'sans-serif'],
        'mono': ['Roboto Mono', 'monospace'],
        'ibm': ['IBM Plex Mono', 'monospace'],
      },
      boxShadow: {
        'glow': '0px 0px 34px rgba(0, 255, 102, 0.10)',
        'glow-accent': '0px 0px 36px rgba(0, 255, 102, 0.24)',
        'card': '0px 0px 0px 1px rgba(255, 255, 255, 0.03) inset, 0px 0px 34px rgba(0, 255, 102, 0.10)',
      },
    },
  },
  plugins: [],
}