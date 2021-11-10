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

mix.js('resources/js/app.js', 'public/javascript')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/timeline.scss', 'public/css')
mix.js('resources/js/add-payement.js', 'public/javascript')
mix.js('resources/js/add-prof.js', 'public/javascript')
mix.js('resources/js/card.js', 'public/javascript')
mix.js('resources/js/delibration.js', 'public/javascript')
mix.js('resources/js/depenses.js', 'public/javascript')
mix.js('resources/js/evaluation.js', 'public/javascript')
mix.js('resources/js/fetch.js', 'public/javascript')
mix.js('resources/js/formation-cards.js', 'public/javascript')
mix.js('resources/js/formation.js', 'public/javascript')
mix.js('resources/js/home.js', 'public/javascript')
mix.js('resources/js/list-etudiants.js', 'public/javascript')
mix.js('resources/js/list-payement.js', 'public/javascript')
mix.js('resources/js/list-prof.js', 'public/javascript')
mix.js('resources/js/list-versement.js', 'public/javascript')
mix.js('resources/js/module-note.js', 'public/javascript')
mix.js('resources/js/module.js', 'public/javascript')
mix.js('resources/js/notes.js', 'public/javascript')
mix.js('resources/js/popup.js', 'public/javascript')
mix.js('resources/js/sidebar.js', 'public/javascript')
mix.js('resources/js/teacher.js', 'public/javascript')
mix.js('resources/js/user.js', 'public/javascript')
mix.js('resources/js/versement.js', 'public/javascript')
