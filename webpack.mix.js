let mix = require("laravel-mix");
const path = require("path");
require("cross-env");

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

mix
  .js("resources/assets/js/app.js", "public/js")
  .vue({
    version: 3,
    extractStyles: false,
    globalStyles: false,
    options: {
      compilerOptions: {
        isCustomElement: (tag) => false,
      },
    },
  })
  .sass("resources/assets/sass/app.scss", "public/css")
  .options({
    processCssUrls: false,
    postCss: [require("autoprefixer")],
  })
  .alias({
    vue$: "vue/dist/vue.runtime.esm-bundler.js",
  })
  .webpackConfig({
    resolve: {
      extensions: [".js", ".vue", ".json"],
      alias: {
        vue$: "vue/dist/vue.runtime.esm-bundler.js",
        "@": path.resolve(__dirname, "resources/assets/js"),
      },
    },
    optimization: {
      providedExports: false,
      sideEffects: false,
      usedExports: false,
    },
    plugins: [
      new (require("webpack").DefinePlugin)({
        __VUE_OPTIONS_API__: JSON.stringify(true),
        __VUE_PROD_DEVTOOLS__: JSON.stringify(false),
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: JSON.stringify(false),
      }),
    ],
  });
