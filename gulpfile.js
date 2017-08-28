/**
 * Gulpfile
 *
 * @see https://travismaynard.com/writing/getting-started-with-gulp
 *
 * @since 0.1.0
 */

'use strict';

// Include gulp
var gulp = require( 'gulp' );

// Include Our Plugins
var jshint = require( 'gulp-jshint' );
var uglify = require( 'gulp-uglify' );
var rename = require( 'gulp-rename' );
var rtlcss = require('gulp-rtlcss');
var cleanCSS = require( 'gulp-clean-css' );

// Files/Paths
var js_src = './assets/javascript';
var js_dest = './dist/assets/javascript';
var js_files = [ js_src + '/**/*.js' ];
var css_src = './assets/styles';
var css_dest = './dist/assets/styles';
var css_files = [ css_src + '/**/*.css' ];

// Lint Task
gulp.task( 'lint_js', function() {
    return gulp.src( js_files )
        .pipe( jshint() )
        .pipe( jshint.reporter( 'default' ) );
});

// Minify JS
gulp.task( 'minify_js', function() {
    return gulp.src( js_files )
        .pipe( uglify() )
        .pipe( rename({ 'suffix' : '.min' }) )
        .pipe( gulp.dest( js_dest ) );
});

// Minify CSS
gulp.task( 'minify_css', function() {
    return gulp.src( css_files )
        .pipe( cleanCSS() )
        .pipe( rename({ 'suffix' : '.min' }) )
        .pipe( gulp.dest( css_dest ) );
});

// RTL CSS
gulp.task( 'rtl_css', function() {
    return gulp.src( css_files )
        .pipe( rtlcss() )
        .pipe( cleanCSS() )
        .pipe( rename({ 'suffix' : '-rtl.min' }) )
        .pipe( gulp.dest( css_dest ) );
});

// Watch Files For Changes
gulp.task( 'watch', function() {
    gulp.watch( js_files, [ 'lint_js', 'minify_js' ]);
    gulp.watch( css_files, [ 'minify_css', 'rtl_css' ]);
});

// Default Task
gulp.task( 'default', [ 'lint_js', 'minify_js', 'minify_css', 'rtl_css', 'watch' ]);
