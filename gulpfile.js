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


// Disable sourcemaps.
elixir.config.sourcemaps = false;


elixir(function(mix) {
    mix.styles([
        "fonts.css",
        "styles.css",
        "styles-responsive.css"
    ], "public/build/css/styles.min.css");
});


elixir(function(mix) {
    mix.scripts([
        "scripts.js"
    ], "public/build/js/scripts.min.js");
});


/* elixir(function(mix) {
    mix.version(["public/stylesheets/styles.min.css", "public/scripts/scripts.min.js"]);
}); */