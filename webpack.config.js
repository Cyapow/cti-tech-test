const path = require('path');

module.exports = {
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '@': path.resolve('resources/js'),
      components: path.resolve('resources/js/Components'),
      forms: path.resolve('resources/js/Forms'),
      layouts: path.resolve('resources/js/Layouts'),
      pages: path.resolve('resources/js/Pages'),
    },
  },
};
