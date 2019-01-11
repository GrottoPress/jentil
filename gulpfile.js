'use strict'

const { src, dest, watch, series, parallel } = require('gulp')

const uglify = require('gulp-uglify')
const rename = require('gulp-rename')
const rtlcss = require('gulp-rtlcss')
const sass = require('gulp-sass')
const sourcemaps = require('gulp-sourcemaps')
const typescript = require('gulp-typescript')
const postcss = require('gulp-postcss')
const cssnano = require('cssnano')
const mqpacker = require('css-mqpacker')
const mqsort = require('sort-css-media-queries')
const focus = require('postcss-focus')
const newer = require('gulp-newer')

const paths = {
    styles: {
        src: ['./assets/styles/**/*.scss'],
        dest: './dist/styles'
    },
    scripts: {
        src: ['./assets/scripts/**/*.ts'],
        dest: './dist/scripts'
    },
    vendor: {
        dest: {
            dist: './dist/vendor',
            assets: './assets/vendor'
        }
    }
}

function _scripts(done)
{
    src(paths.scripts.src)
        .pipe(newer(paths.scripts.dest))
        .pipe(sourcemaps.init())
        .pipe(typescript({
            'module': 'commonjs',
            'target': 'es5',
            'removeComments': true,
            'noImplicitAny': true,
            'noImplicitThis': true,
            'strictNullChecks': true,
            'strictFunctionTypes': true
        }))
        .pipe(uglify())
        .pipe(rename({'suffix': '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(paths.scripts.dest))

    done()
}

function _styles(done)
{
    src(paths.styles.src)
        .pipe(newer(paths.styles.dest))
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([focus(), mqpacker({sort: mqsort}), cssnano()]))
        .pipe(rename({'suffix': '.min'}))
        .pipe(sourcemaps.write())
        .pipe(dest(paths.styles.dest))
        .pipe(rtlcss())
        .pipe(rename((path) =>
            path.basename = path.basename.replace('.min', '-rtl.min')
        ))
        .pipe(dest(paths.styles.dest))

    done()
}

function _vendor(done)
{
    src([
        './node_modules/html5shiv/dist/html5shiv.min.js',
        './node_modules/respond.js/dest/respond.min.js',
        './node_modules/what-input/dist/what-input.min.js'
    ])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/normalize.css/normalize.css'])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(postcss([cssnano()]))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/@fortawesome/fontawesome-free/js/all.min.js'])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(rename({'basename': 'font-awesome.min'}))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/@fortawesome/fontawesome-free/js/v4-shims.min.js'])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(rename({'basename': 'font-awesome-v4-shims.min'}))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/@grottopress/scss/**'])
        .pipe(newer(paths.vendor.dest.assets))
        .pipe(dest(`${paths.vendor.dest.assets}/@grottopress/scss`))

    done()
}

function _watch()
{
    watch(paths.scripts.src, {ignoreInitial: false}, _scripts)
    watch(paths.styles.src, {ignoreInitial: false}, _styles)
}

exports.styles = _styles
exports.scripts = _scripts
exports.vendor = _vendor
exports.watch = _watch

exports.default = series(parallel(_styles, _scripts), _watch)
