const mix = require('laravel-mix');
const path = require('path')
const PrerenderSPAPlugin = require('prerender-spa-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin');
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

mix.options({
  uglify: {
    uglifyOptions: {
      compress: {
        drop_console: true,
      }
    }
  }
});

mix.setPublicPath('public')
  .setResourceRoot('../')
  .js('resources/js/app.js', 'public/js')
  // .js('resources/js/studio/app.js', 'public/studio/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/app-dark.scss', 'public/css')
  // .sass('resources/sass/studio/app.scss', 'public/studio/css')
  .copy('resources/favicon.ico', 'public')
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.pug$/,
          oneOf: [
            {
              resourceQuery: /^\?vue/,
              use: ['pug-plain-loader']
            },
            {
              use: ['raw-loader', 'pug-plain-loader']
            }
          ]
        },
        { test: /jquery-mousewheel/, loader: "imports-loader?define=>false&this=>window" },
        { test: /malihu-custom-scrollbar-plugin/, loader: "imports-loader?define=>false&this=>window" },
        {
          test: /\.worker\.js$/,
          use: { loader: 'worker-loader' }
        }
      ],

    },
    plugins: [
      new HtmlWebpackPlugin({
        template: path.join(__dirname, './resources/views/layout.blade.php'),
        inject: false,
        filename: path.resolve('dist/index.html'),
      }),
      new PrerenderSPAPlugin({
        staticDir: path.join(__dirname, 'dist'),
        routes: [
          '/', '/blog'
        ],
        indexPath: path.resolve('dist/index.html'),
        renderer: new PrerenderSPAPlugin.PuppeteerRenderer({
          inject: {},
          renderAfterTime: 3000,
        }),
        postProcess (renderedRoute) {
          renderedRoute.html = renderedRoute.html
            .replace('id="app"', 'id="app" data-server-rendered="true"');
          return renderedRoute;
        }
      })
    ]
  })
  .version();
