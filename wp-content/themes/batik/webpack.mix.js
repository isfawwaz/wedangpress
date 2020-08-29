const mix = require( 'laravel-mix' );
const tailwindcss = require('tailwindcss')

mix.setPublicPath('./assets/dist/');

// Compile Assets
mix.js( 'assets/src/scripts/main.js', 'assets/dist/js' )
    .js( 'assets/src/scripts/admin.js', 'assets/dist/js' )
    // .sass( 'assets/src/sass/tailwind.scss', 'assets/dist/css' )
    .sass( 'assets/src/sass/style.scss', 'assets/dist/css' )
	.sass( 'assets/src/sass/woocommerce.scss', 'assets/dist/css' )
    .sass( 'assets/src/sass/admin.scss', 'assets/dist/css' )
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('tailwind.config.js'),
        ]
    });

// This bit of configuration updates the generated class names from CSS Modules.
// It will keep the original name (eg. card) in the final class name
mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '~': __dirname
        }
    },
    module: {
        rules: []
    }
});