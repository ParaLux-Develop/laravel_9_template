const mix = require("laravel-mix");

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
mix.sourceMaps()
    .browserSync({
        files: [
            "./resources/views/**/*",
            "./resources/views/*",
            "./resources/js/**/*",
            "./resources/js/*",
            "./resources/sass/**/*",
            "./resources/sass/*",
            "./app/**/**/*",
            "./app/**/*",
            "./routes/*"
        ],
        browser: "default",
        proxy: {
            target: "http://localhost:10780/"
        },
        watchOptions: {
            usePolling: true,
            interval: 500
        }
    });

// プロダクション・ローカル共通
mix.js("resources/js/app.js", "public/js")
  .sass("resources/sass/app.scss", "public/css")
  .version()