const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/alpine.js", "public/js")
    .js("resources/js/color_picker.js", "public/js")
    .postCss("resources/css/main.css", "public/css")
    .postCss("resources/css/flatpickr.min.css", "public/css")
    .postCss("resources/css/loading.css", "public/css")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
    ]);

if (mix.inProduction()) {
    mix.version();
}
