'use strict'

const { dest, parallel, series, src, watch } = require('gulp')

const bsync = require('browser-sync').create()
const cssnano = require('cssnano')
const filter = require('gulp-filter')
const focus = require('postcss-focus')
const newer = require('gulp-newer')
const postcss = require('gulp-postcss')
const rename = require('gulp-rename')
const rollup = require('gulp-better-rollup')
const rtlcss = require('gulp-rtlcss')
const sass = require('gulp-sass')
const sh = require('shelljs')
const uglify = require('gulp-uglify')

const bsConfig = require('./bs-config')
const roConfig = require('./rollup.config')

const uglifyOpts = {output: {comments: /(^!|\@license|\@preserve)/i}}

const paths = {
    scripts: {
        dest: roConfig.output.dir,
        mapDest: '.',
        src: roConfig.input,
        watchSrc: ['./assets/scripts/**/*.ts']
    },
    serve: {
        src: bsConfig.files
    },
    styles: {
        dest: './dist/styles',
        mapDest: '.',
        src: ['./assets/styles/*.scss'],
        watchSrc: ['./assets/styles/**/*.scss']
    },
    vendor: {
        dest: {
            assets: './assets/vendor',
            dist: './dist/vendor'
        }
    }
}

function _chmod(done)
{
    sh.chmod('-R', 'a+x', './bin', './vendor/bin', './node_modules/.bin')

    done()
}

function _clean(done)
{
    sh.rm(
        '-rf',
        paths.styles.dest,
        paths.scripts.dest,
        paths.vendor.dest.dist,
        paths.vendor.dest.assets
    )

    done()
}

function _scripts(done)
{
    src(paths.scripts.src, {sourcemaps: true})
        .pipe(newer(paths.scripts.dest))
        .pipe(rollup({plugins: roConfig.plugins}, roConfig.output))
        .pipe(rename({'suffix': '.min', 'extname': '.js'}))
        .pipe(uglify(uglifyOpts))
        .pipe(dest(paths.scripts.dest, {sourcemaps: paths.scripts.mapDest}))

    done()
}

function _serve(done)
{
    bsync.init(bsConfig)

    done()
}

function _styles(done)
{
    src(paths.styles.src, {sourcemaps: true})
        .pipe(newer(paths.styles.dest))
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([focus(), cssnano()]))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(paths.styles.dest, {sourcemaps: paths.styles.mapDest}))
        .pipe(filter(['**/*.css']))
        .pipe(rtlcss())
        .pipe(rename(path => {
            path.basename = path.basename.replace('.min', '-rtl.min')
        }))
        .pipe(dest(paths.styles.dest, {sourcemaps: paths.styles.mapDest}))

    done()
}

function _vendor(done)
{
    src([
        './node_modules/html5shiv/dist/html5shiv.min.js',
        './node_modules/respond.js/dest/respond.min.js',
        './node_modules/what-input/dist/what-input.min.js',
        './node_modules/jquery/dist/jquery.min.js',
        './node_modules/jquery-migrate/dist/jquery-migrate.min.js'
    ])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(uglify(uglifyOpts))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/normalize.css/normalize.css'])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(postcss([cssnano()]))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/@fortawesome/fontawesome-free/js/all.min.js'])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(uglify(uglifyOpts))
        .pipe(rename({'basename': 'font-awesome.min'}))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/@fortawesome/fontawesome-free/js/v4-shims.min.js'])
        .pipe(newer(paths.vendor.dest.dist))
        .pipe(uglify(uglifyOpts))
        .pipe(rename({'basename': 'font-awesome-v4-shims.min'}))
        .pipe(dest(paths.vendor.dest.dist))

    src(['./node_modules/@grottopress/scss/**'])
        .pipe(newer(paths.vendor.dest.assets))
        .pipe(dest(`${paths.vendor.dest.assets}/@grottopress/scss`))

    done()
}

function _watch(done)
{
    watch(paths.scripts.watchSrc, {ignoreInitial: false}, _scripts)
    watch(paths.styles.watchSrc, {ignoreInitial: false}, _styles)

    done()
}

exports.chmod = _chmod
exports.clean = _clean
exports.scripts = _scripts
exports.serve = _serve
exports.styles = _styles
exports.vendor = _vendor
exports.watch = _watch

exports.default = series(parallel(_styles, _scripts), _serve, _watch)
