var gulp = require('gulp');
var rename = require('gulp-rename');
var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
var paths = {
    'source': 'resources/assets/',
    'bootstrap': 'lib/bootstrap/dist/',
    'jquery': 'lib/jquery/dist/'
}

elixir(function(mix) {

    mix.copy(paths.source + paths.bootstrap + 'fonts/**', 'public/assets/fonts/');

    // Combine scripts
    mix.scripts([
        paths.jquery + 'jquery.js',
        paths.bootstrap + 'js/bootstrap.js'
    ], 'public/assets/js', paths.source);

    mix.styles([
        paths.bootstrap + 'css/bootstrap.css',
        paths.bootstrap + 'css/bootstrap-theme.css'
    ], 'public/assets/css', paths.source);

    mix.version(['assets/js/all.js', 'assets/css/all.css']);
});