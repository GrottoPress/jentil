/**
 * Gulpfile
 *
 * @since 0.1.0
 */

'use strict'

// Include gulp
const gulp = require('gulp')

// Include plugins
const jshint = require('gulp-jshint')
const uglify = require('gulp-uglify')
const rename = require('gulp-rename')
const rtlcss = require('gulp-rtlcss')
const cleanCSS = require('gulp-clean-css')
const sass = require('gulp-sass')
const sourcemaps = require('gulp-sourcemaps')

// Files/Paths
const js_files = ['./assets/scripts/**/*.js']
const js_dest = './dist/assets/scripts'
const sass_files = ['./assets/styles/**/*.scss']
const sass_dest = './dist/assets/styles'

// Lint JS
gulp.task('lint_js', () =>
    gulp.src(js_files)
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
)

// Minify JS
gulp.task('minify_js', () =>
    gulp.src(js_files)
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(rename({'suffix' : '.min'}))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(js_dest))
)

// Compile scss, rtl and minify scss
gulp.task('compile_sass', () =>
    gulp.src(sass_files)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    // .pipe(cleanCSS({format: 'beautify'}))
    // .pipe(gulp.dest(sass_dest))
    .pipe(cleanCSS())
    .pipe(rename({'suffix' : '.min'}))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(sass_dest))
    .pipe(rtlcss())
    .pipe(rename((path) =>
        path.basename = path.basename.replace('.min', '-rtl.min')
    ))
    .pipe(gulp.dest(sass_dest))
)

// Watch files for changes
gulp.task('watch', () => {
    gulp.watch(js_files, ['lint_js', 'minify_js'])
    gulp.watch(sass_files, ['compile_sass'])
})

// Default task
gulp.task('default', [
    'lint_js',
    'minify_js',
    'compile_sass',
    'watch'
])
