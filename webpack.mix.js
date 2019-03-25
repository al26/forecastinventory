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

mix.react('resources/js/app.js', 'public/js')
    .react('resources/js/admin.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/vendor/sufee/scss/admin.scss', 'public/css')
    .options({ processCssUrls: false })
    .copyDirectory('resources/images', 'public/img', false)
    .copyDirectory('resources/vendor/fontawesome', 'public', false)
    .copyDirectory('resources/vendor/sufee/images', 'public/img', false);
