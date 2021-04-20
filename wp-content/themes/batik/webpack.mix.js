const mix = require( 'laravel-mix' );

mix.setPublicPath('./assets/dist/');

// Compile Assets
mix.ts( 'assets/src/scripts/main.js', 'assets/dist/js' )
    .vue({
        version: 2
    });

mix.js( 'assets/src/scripts/admin.js', 'assets/dist/js' )
    .sass( 'assets/src/sass/bootstrap.scs', 'assets/dist/css' )
    .sass( 'assets/src/sass/style.scss', 'assets/dist/css' )
	.sass( 'assets/src/sass/woocommerce.scss', 'assets/dist/css' )
    .sass( 'assets/src/sass/admin.scss', 'assets/dist/css' );

// This bit of configuration updates the generated class names from CSS Modules.
// It will keep the original name (eg. card) in the final class name
mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': __dirname,
            '~': __dirname
        }
    },
    module: {
        rules: []
    }
});