const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css').sourceMaps();

    /*mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('autoprefixer'),
    ])
    .webpackConfig(require('./webpack.config'));*/
    module.exports = {
        module: {
          rules: [
            // SASS has different line endings than SCSS
            // and cannot use semicolons in the markup
            {
              test: /\.sass$/,
              use: [
                'vue-style-loader',
                'css-loader',
                {
                  loader: 'sass-loader',
                  // Requires sass-loader@^7.0.0
                  options: {
                    // This is the path to your variables
                    data: "@import '@/styles/variables.scss'"
                  },
                  // Requires sass-loader@^8.0.0
                  options: {
                    // This is the path to your variables
                    prependData: "@import '@/styles/variables.scss'"
                  },
                  // Requires >= sass-loader@^9.0.0
                  options: {
                    // This is the path to your variables
                    additionalData: "@import '@/styles/variables.scss'"
                  },
                },
              ],
            },
            // SCSS has different line endings than SASS
            // and needs a semicolon after the import.
            {
              test: /\.scss$/,
              use: [
                'vue-style-loader',
                'css-loader',
                {
                  loader: 'sass-loader',
                  // Requires sass-loader@^7.0.0
                  options: {
                    // This is the path to your variables
                    data: "@import '@/styles/variables.scss';"
                  },
                  // Requires sass-loader@^8.0.0
                  options: {
                    // This is the path to your variables
                    prependData: "@import '@/styles/variables.scss';"
                  },
                  // Requires sass-loader@^9.0.0
                  options: {
                    // This is the path to your variables
                    additionalData: "@import '@/styles/variables.scss';"
                  },
                },
              ],
            },
          ],
        },
      }