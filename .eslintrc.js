const path = require('path');

module.exports = {
  env: {
    node: true,
  },
  extends: ['eslint:recommended', 'plugin:vue/vue3-recommended', 'prettier'],
  rules: {
    // override/add rules settings here, such as:
    // 'vue/no-unused-vars': 'error'
  },
  globals: {
    window: true,
    document: true,
    route: true,
  },
  settings: {
    'import/resolver': {
      webpack: {
        config: {
          resolve: {
            alias: {
              '@': path.resolve('resources'),
              components: path.resolve('resources/js/Components'),
              forms: path.resolve('resources/js/Forms'),
              layouts: path.resolve('resources/js/Layouts'),
              pages: path.resolve('resources/js/Pages'),
            },
          },
        },
      },
    },
  },
};
