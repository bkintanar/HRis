var elixir = require('laravel-elixir');

var paths = {
    'bower_components': './resources/assets/bower_components',
    'fonts': './resources/fonts',
    'build': './public/build',
    'plugins': './public/js/plugins',
    'scripts': './public/js',
    'styles': './public/css',
    'output': './public/output',
    'root': './'
};

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

elixir(function(mix) {

    /**
     * Styles
     */
    mix.less([
        'dependencies.less'
    ])
    .sass([
        'style.sass'
    ])
    .styles([
        'bootstrap.css',
        'font-awesome.css',
        'animate.css',
        'style.css'
    ], null, paths.styles);

    /**
     * Scripts
     */
    mix.scripts([
        paths.bower_components + '/jquery/dist/jquery.min.js',
        paths.bower_components + '/bootstrap/dist/js/bootstrap.min.js',
        paths.plugins + '/metisMenu/jquery.metisMenu.js',
        paths.plugins + '/slimscroll/jquery.slimscroll.min.js',
        paths.plugins + '/pace/pace.min.js',
        paths.scripts + '/inspinia.js'
    ], null, './')

    /**
     * Styles and Script Version
     */
    mix.version([paths.styles + '/all.css', paths.scripts + '/all.js']);

    /**
     * Fonts & Images
     */
    mix.copy(paths.bower_components + '/font-awesome/fonts', paths.build + '/fonts')
       .copy(paths.bower_components + '/bootstrap/fonts', paths.build + '/fonts')
       .copy(paths.fonts + '/OpenSans', paths.build + '/fonts/OpenSans')
       .copy(paths.styles + '/patterns', paths.build + '/css/patterns');
});
