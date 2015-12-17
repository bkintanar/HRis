// Disable notify
//process.env.DISABLE_NOTIFIER = true

// I need some magic
var elixir = require('laravel-elixir');
require('elixir-vuemaker');

elixir.config.js.browserify.transformers.push({ name: 'envify' });

// Generate source map for easier debugging in dev tools
elixir.config.js.browserify.options.debug = true;

var paths = {
    'jquery': './bower_components/jquery/',
    'vue': './bower_components/vue/',
    'router': './bower_components/vue-router/',
    'bootstrap': './bower_components/bootstrap-sass/assets/',
    'fontawesome': './bower_components/font-awesome/',
    'cookies': './bower_components/cookies-js/',
    'bourbon': './bower_components/bourbon/app/assets/',
    'dropzone': './bower_components/dropzone/',
    'datepicker': './bower_components/bootstrap-datepicker/',
    'jasny': './bower_components/jasny-bootstrap/',
    'icheck': './bower_components/iCheck/',
    'chosen': './bower_components/chosen/',
    'metisMenu': './bower_components/metisMenu/',
    'slimScroll': './bower_components/slimScroll/',
    'sweetalert2': './bower_components/sweetalert2/',
    'moment': './bower_components/moment/',
    'datetimepicker': './bower_components/eonasdan-bootstrap-datetimepicker/',
    'nestable': './bower_components/nestable/',
    'inspinia': './resources/assets/sass/inspinia/'
}

elixir(function (mix) {
    mix.sass("*.*", 'public/css/app.css', {includePaths: [paths.bootstrap + 'stylesheets', paths.fontawesome + 'scss', paths.bourbon + 'stylesheets']});
    mix.sass("inspinia/style.sass", 'public/css/inspinia.css');
    mix.styles([
        'public/css/app.css',
        'public/css/animate.css',
        'public/css/icheck.css',
        paths.datepicker + 'dist/css/bootstrap-datepicker3.min.css',
        paths.jasny + 'dist/css/jasny-bootstrap.min.css',
        paths.metisMenu + 'dist/metisMenu.min.css',
        paths.sweetalert2 + 'dist/sweetalert2.css',
        paths.datetimepicker + 'build/css/bootstrap-datetimepicker.min.css',
        'public/css/inspinia.css'
    ], 'public/css/all.css', './');//.version('public/css/app.css');
    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap')
        .copy(paths.fontawesome + 'fonts/**', 'public/fonts/fontawesome')
        .copy(paths.chosen + '*.png', 'public/images')
        .copy('resources/assets/tinymce/**', 'public/tinymce');
    mix.scripts([
            paths.jquery + "dist/jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.cookies + "dist/cookies.js",
            paths.dropzone + "dist/dropzone.js",
            paths.datepicker + "dist/js/bootstrap-datepicker.min.js",
            paths.jasny + "dist/js/jasny-bootstrap.min.js",
            paths.icheck + "icheck.min.js",
            paths.chosen + "chosen.jquery.min.js",
            paths.metisMenu + "dist/metisMenu.min.js",
            paths.slimScroll + "jquery.slimscroll.min.js",
            paths.sweetalert2 + "dist/sweetalert2.min.js",
            paths.moment + "min/moment.min.js",
            paths.datetimepicker + "build/js/bootstrap-datetimepicker.min.js",
            paths.nestable + "jquery.nestable.js",
            "resources/assets/js/vendor/ie10-viewport-bug-workaround.js",
            "resources/assets/js/vendor/inspinia.js"
        ], 'public/js/vendor.js', './');
    mix.vuemaker([
            'resources/assets/js/components/**/*.+(js|css|html)',
            'resources/assets/js/app.+(js|css|html)'
        ], 'resources/assets/js/compiled')
        .browserify('bootstrap.js', 'public/js/app.js');

    /*.version([
     'js/vendor.js',
     'js/default.js',
     'js/user.js',
     'js/admin.js'
     ])*/
    ;
});
