var gulp = require('gulp');
var sass = require('gulp-sass');
var minifycss = require('gulp-minify-css');
var rename = require("gulp-rename");
//var notify = require("gulp-notify");

gulp.task('sass', function () {
 gulp.src('resources/assets/sass/style.sass')
     .pipe(sass())
     .pipe(minifycss({keepBreaks:false}))
     .pipe(rename({suffix: '.min'}))
     .pipe(gulp.dest('public/min-css'));
 //.pipe(notify("Hello Gulp!"));
});


gulp.task('watch', function() {
 gulp.watch('resources/assets/sass/*.sass', ['sass']);


});

gulp.task('default', ['sass', 'watch']);



