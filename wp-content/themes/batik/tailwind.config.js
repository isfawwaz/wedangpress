module.exports = {
  purge: [],
  theme: {
    container: {
      screens: {
        sm: "540px",
        md: "720px",
        lg: "960px",
        xl: "1140px"
      }
    },
    fontFamily: {
      sans: ['Poppins', 'Arial', 'sans-serif'],
      serif: ['Georgia', 'Cambria', '"Times New Roman"', 'Times', 'serif'],
      mono: ['Menlo', 'Monaco', 'Consolas', '"Liberation Mono"', '"Courier New"', 'monospace'],
      heading: ['Poppins', 'sans-serif']
    },
    extend: {
      colors: {
        'pre': '#eee',
        'abbr': '#666',
        'ins': '#fff9c0',
        'hr': '#CCC',
        'screen': '#f1f1f1',
        'text-screen': '#21759b',
        'onyx': '#0b051c',
        'oxford': '#171a3b',
        'primary': '#d10459',
        'accent': '#43dde2',
        'primary-text': '#434343',
        'secondary-text': '#888888',
        'tertiary-text': '#BABABA'
      },
      cursor: {
        help: 'help'
      },
      fontFamily: {
        'code': 'Monaco, Consolas, "Andale Mono", "DejaVu Sans Mono", monospace'
      },
      fontSize: {
        '125p': '125%'
      },
      inset: {
        '100p': '100%',
        '-999': '-999em'
      },
      spacing: {
        '25': '6.25rem',
        '50p': '50%',
        '1x': '1px',
        '200x': '200px'
      },
      zIndex: {
        '99999': '99999px'
      }
    },
  },
  variants: {},
  plugins: [],
}
