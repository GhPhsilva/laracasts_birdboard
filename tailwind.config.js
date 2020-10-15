module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
    // defaultLineHeights: true,
    // standardFontWeights: true
  },
  purge: [],
  theme: {
    extend: {
      colors: {
        'grey-light': '#F5F6F9',
        grey: 'rgba(0, 0, 0, 0.4)',
        blue: '#47cdff'
      }
    }
  },
  variants: {},
  plugins: [
    require('tailwindcss'),
    require('autoprefixer'),
  ]
}
