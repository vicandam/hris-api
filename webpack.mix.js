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

// mix.js('public/js/pages/dev/profile.js', 'public/js/pages/prod/profile.js');
mix.js('public/js/pages/dev/home.js', 'public/js/pages/prod/home.js');
// mix.js('public/js/pages/dev/account.js', 'public/js/pages/prod/account.js');
// mix.js('public/js/pages/dev/change-password.js', 'public/js/pages/prod/change-password.js');
// mix.js('public/js/pages/dev/post-detail.js', 'public/js/pages/prod/post-detail.js');
mix.js('public/js/pages/dev/global.js', 'public/js/pages/prod/global.js');

// bundle the css
mix.styles([
    'public/css/app.css',
    'public/css/style.css',
    'public/css/loader.css'
], 'public/css/bundle.css');

// Not working for now, please fix this one
mix.scripts([
    'public/js/jquery-3.3.1.slim.min.js',
    'public/js/popper.min.js',
    'public/js/bootstrap.min.js',
    'public/js/vue.min.js',
    'public/js/axios.js',
    'public/js/vue-infinite-scroll-2.0.2.js',
    'public/js/pages/prod/global.js'
], 'public/js/bundle.js');