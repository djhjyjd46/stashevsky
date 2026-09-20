export default {
  content: [
    './**/*.php',
    './src/**/*.{js,ts}'
  ],
  corePlugins: {
    preflight: false
  },
  theme: {
    extend: {
      colors: {
        blue: '#212E48',
        gold: '#C89E42',
        white: '#FFFFFF'
      }
    }
  },
  plugins: []
};
