/**
 * Gulpfile
 *
 * @see         https://travismaynard.com/writing/getting-started-with-gulp
 *
 * @since       Jentil 0.1.0
 */

// Include gulp
var gulp = require( 'gulp' );

// Include Our Plugins
var jshint = require( 'gulp-jshint' );
var uglify = require( 'gulp-uglify' );
var rename = require( 'gulp-rename' );
var rtlcss = require('gulp-rtlcss');
var cleanCSS = require( 'gulp-clean-css' );

// Paths
var js_dir = './assets/javascript';
var js_files = [ js_dir + '/*.js', '!' + js_dir + '/*.min.js' ];
var css_dir = './assets/styles';
var css_files = [ css_dir + '/*.css', '!' + css_dir + '/*.min.css' ];
var css_rtl_files = [ css_dir + '/*.css', '!' + css_dir + '/*.min.css', '!' + css_dir + '/*-rtl.css' ];

// Lint Task
gulp.task( 'lint', function() {
    return gulp.src( js_files )
        .pipe( jshint() )
        .pipe( jshint.reporter( 'default' ) );
});

// Minify JS
gulp.task( 'minify_js', function() {
    return gulp.src( js_files )
        .pipe( uglify() )
        .pipe( rename({ 'suffix' : '.min' }) )
        .pipe( gulp.dest( js_dir ) );
});

// RTL CSS
gulp.task( 'rtl_css', function() {
    return gulp.src( css_rtl_files )
        .pipe( rtlcss() )
        .pipe( rename({ 'suffix' : '-rtl' }) )
        .pipe( gulp.dest( css_dir ) );
});

// Minify CSS
gulp.task( 'minify_css', function() {
    return gulp.src( css_files )
        .pipe( cleanCSS() )
        .pipe( rename({ 'suffix' : '.min' }) )
        .pipe( gulp.dest( css_dir ) );
});

// Watch Files For Changes
gulp.task( 'watch', function() {
    gulp.watch( js_files, [ 'lint', 'minify_js' ]);
    gulp.watch( css_files, [ 'minify_css' ]);
});

// Default Task
gulp.task( 'default', [ 'lint', 'minify_js', 'rtl_css', 'minify_css', 'watch' ]);