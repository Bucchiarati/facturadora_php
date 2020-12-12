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

//mix.js('resources/js/factura.js', 'public/js');

mix.browserSync({
    proxy: 'http://localhost/facturadora/public/dashboard/factura/facturar?id=25936862',
    open: false
});