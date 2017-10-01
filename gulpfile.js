/**
 * Gulpfile
 *
 * @see https://travismaynard.com/writing/getting-started-with-gulp
 *
 * @since 0.1.0
 */

'use strict';

// Include gulp
const gulp = require('gulp');

// Include Our Plugins
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const rtlcss = require('gulp-rtlcss');
const cleanCSS = require('gulp-clean-css');
const sass = require('gulp-sass');

// Files/Paths
const js_src = './assets/scripts';
const js_dest = './dist/assets/scripts';
const js_files = [js_src+'/**/*.js'];
const sass_src = './assets/styles';
const sass_files = [sass_src+'/**/*.scss'];
const sass_dest = './dist/assets/styles';

// Lint Task
gulp.task('lint_js', function () {
    return gulp.src(js_files)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Minify JS
gulp.task('minify_js', function () {
    return gulp.src(js_files)
        .pipe(uglify())
        .pipe(rename({'suffix' : '.min'}))
        .pipe(gulp.dest(js_dest));
});

// Compile scss, rtl and minify scss
gulp.task('compile_sass', function () {
    return gulp.src(sass_files)
        .pipe(sass().on('error', sass.logError))
        // .pipe(cleanCSS({format: 'beautify'}))
        .pipe(gulp.dest(sass_dest))
        .pipe(cleanCSS())
        .pipe(rename({'suffix' : '.min'}))
        .pipe(gulp.dest(sass_dest))
        .pipe(rtlcss())
        .pipe(rename(function (path) {
            path.basename = path.basename.replace('.min', '-rtl.min');
        }))
        .pipe(gulp.dest(sass_dest));
});

// Watch Files For Changes
gulp.task('watch', function () {
    gulp.watch(js_files, ['lint_js', 'minify_js']);
    gulp.watch(sass_files, ['compile_sass']);
});

// Default Task
gulp.task('default', [
    'lint_js',
    'minify_js',
    'compile_sass',
    'watch'
]);
