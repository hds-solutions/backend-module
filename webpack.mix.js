// load environment config
const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({
    path: '../../.env'/*, debug: true*/
}));

// load mix
const mix = require('laravel-mix');

// Allow multiple Laravel Mix applications
require('laravel-mix-merge-manifest');
mix.mergeManifest();

// set public path
mix.setPublicPath('../../public').mergeManifest();

// set assets root
assetsRoot = process.env.ASSET_URL;
assetsRoot = assetsRoot !== undefined ? assetsRoot : process.env.APP_URL;
assetsRoot = assetsRoot !== undefined ? assetsRoot : 'https://localhost';
mix.setResourceRoot( assetsRoot );
// configure mix
mix.options({
    fileLoaderDirs: {
        images: 'backend-module/assets/images',
        fonts: 'backend-module/assets/fonts',
    }
});
// Autoload libraries aliases
mix.autoload({
    // autoload jQuery
    'jquery': [ '$', 'jQuery', 'window.$', 'window.jQuery' ],
});

// execute mix
mix
    /** ****************** **
     ** Backend components **
     ** ****************** **/
    .js('resources/assets/js/app.js',       'backend-module/assets/js')
    .sass('resources/assets/sass/app.scss', 'backend-module/assets/css')

// create new version only for production
;if (mix.inProduction()) mix.version();
// enable browsersync
// else mix.browserSync('laravel.templates.vanirel');
