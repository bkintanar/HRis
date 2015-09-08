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
    	'dependencies.css',
        'animate.css',
        'plugins/iCheck/custom.css',
        '../../resources/assets/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
        'style.css',
    ], null, paths.styles);

    /**
     * Scripts
     */
    mix.scripts([
        paths.bower_components + '/jquery/dist/jquery.min.js',
        paths.bower_components + '/bootstrap/dist/js/bootstrap.min.js',
        paths.bower_components + '/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        paths.bower_components + '/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
        paths.bower_components + '/chosen/chosen.jquery.min.js',
        paths.bower_components + '/iCheck/icheck.min.js',
        paths.bower_components + '/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        paths.bower_components + '/sweetalert2/dist/sweetalert2.min.js',
        //paths.bower_components + '/cropper/dist/cropper.min.js',
        paths.plugins + '/metisMenu/jquery.metisMenu.js',
        paths.plugins + '/slimscroll/jquery.slimscroll.min.js',
        paths.plugins + '/pace/pace.min.js',
        paths.scripts + '/inspinia.js',
        paths.scripts + '/custom.js'
    ], null, './');

    /**
     * Styles and Script Version
     */
    mix.version([paths.styles + '/all.css', paths.scripts + '/all.js']);

    /**
     * Fonts & Images
     */
    mix.copy(paths.bower_components + '/font-awesome/fonts', paths.build + '/fonts')
       .copy(paths.bower_components + '/bootstrap/fonts', paths.build + '/fonts')
       .copy(paths.bower_components + '/chosen/*.png', paths.build + '/css')
       .copy(paths.bower_components + '/cropper/src/img/bg.png', paths.build + '/img/')
       .copy(paths.styles + '/plugins/iCheck/*.png', paths.build + '/css')
       .copy(paths.fonts + '/OpenSans', paths.build + '/fonts')
       .copy(paths.styles + '/patterns', paths.build + '/css/patterns');
});
