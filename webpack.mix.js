const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("./resources/js/Website/app.js", "js/website/app.js")
    .vue()
    .sass("resources/js/Website/src/scss/main.scss", "public/front/css/main.css")
    .options({
        postCss: [
            require("autoprefixer")({
                browsers: ["last 4 versions"]
            })
        ]
    });


mix.js("./resources/js/Panel/app.js", "js/panel/app.js").vue()
mix.browserSync("http://vue-laravel-panel.test");


