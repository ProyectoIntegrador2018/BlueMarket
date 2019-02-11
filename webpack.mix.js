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

mix.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css', { implementation: require('node-sass') });
mix.copyDirectory('resources/img', 'public/img');

if (mix.inProduction()) {
	mix.version(); // cache-busting in production
}

mix.browserSync({
	proxy: "localhost:8010",
	open: false,
	ghostMode: false
});
