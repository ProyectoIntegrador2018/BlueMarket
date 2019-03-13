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
.sass('resources/sass/app.scss', 'public/css', { implementation: require('node-sass') })
.sass('resources/sass/admin.scss', 'public/css', { implementation: require('node-sass') })
.options({processCssUrls: false });

mix.copyDirectory('resources/img', 'public/img');
mix.scripts(['resources/js/inputValidation.js'], 'public/js/inputValidation.js');
mix.scripts(['resources/js/teams.js'], 'public/js/teams.js');
mix.browserSync({
	proxy: "localhost:8010",
	// node node_modules/browser-sync/dist/bin.js start --proxy localhost:8010 --files \"public/*\" \"resources/views/**/*.blade.php\"
})

if (mix.inProduction()) {
	mix.version(); // cache-busting in production
}

if (!mix.inProduction()) {
	mix.webpackConfig({
		devtool: 'source-map'
	})
	.sourceMaps();
}
