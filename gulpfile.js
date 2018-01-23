/**
 * Gulpfile
 *
 * @since 0.1.0
 */

'use strict'

/**
 * Import gulp, plugins
 */
const gulp = require('gulp')
const uglify = require('gulp-uglify')
const rename = require('gulp-rename')
const rtlcss = require('gulp-rtlcss')
const cleanCSS = require('gulp-clean-css')
const sass = require('gulp-sass')
const sourcemaps = require('gulp-sourcemaps')
const ts = require('gulp-typescript')

/**
 * Define paths
 */
const ts_files = ['./assets/scripts/**/*.ts']
const js_dest = './dist/scripts'
const sass_files = ['./assets/styles/**/*.scss']
const sass_dest = './dist/styles'

/**
 * Compile ts, rtl and minify js
 */
gulp.task('scripts', () =>
    gulp.src(ts_files)
    .pipe(sourcemaps.init())
    .pipe(ts({
        "module": "commonjs",
        "target": "es3",
        "noImplicitAny": true,
        "noImplicitUseStrict": true,
        "noImplicitThis": true,
        "strictNullChecks": true,
        "strictFunctionTypes": true
    }))
    .pipe(uglify())
    .pipe(rename({'suffix' : '.min'}))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(js_dest))
)

/**
 * Compile scss, rtl, minify css
 */
gulp.task('styles', () =>
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

/**
 * Watch files for changes
 */
gulp.task('watch', () => {
    gulp.watch(ts_files, ['scripts'])
    gulp.watch(sass_files, ['styles'])
})

/**
 * Default task
 */
gulp.task('default', [
    'scripts',
    'styles',
    'watch'
])
