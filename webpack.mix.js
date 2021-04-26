// load environment config
const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({
    path: '../../../.env'/*, debug: true*/
}));

// load mix
const mix = require('laravel-mix');

// Allow multiple Laravel Mix applications
require('laravel-mix-merge-manifest');

// set public path
mix.setPublicPath(public = '../../../public').mergeManifest();

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

// disable notifications in prod
if (mix.inProduction()) mix.disableNotifications();

// execute mix
mix
    /** ****************** **
     ** Backend components **
     ** ****************** **/
    .js('resources/assets/js/app.js',       'backend-module/assets/js')
    .sass('resources/assets/sass/app.scss', 'backend-module/assets/css')

    .copy('node_modules/pdfmake/build/vfs_fonts.js',        public+'/backend-module/vendor/pdfmake/')
    .copy('node_modules/tinymce/themes',                    public+'/backend-module/vendor/tinymce/themes')
    .copy('node_modules/tinymce/skins',                     public+'/backend-module/vendor/tinymce/skins')

    .copy('resources/assets/images',        public+'/backend-module/assets/images')

    // .copy('node_modules/datatables.net-buttons/js/dataTables.buttons.min.js', public+'/backend-module/vendor/datatables')

// create new version only for production
;if (mix.inProduction()) mix.version();
// enable browsersync
// else mix.browserSync('laravel.templates.vanirel');
