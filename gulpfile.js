'use strict'

const { src, dest, watch, series, parallel } = require('gulp')

const uglify = require('gulp-uglify')
const rename = require('gulp-rename')
const rtlcss = require('gulp-rtlcss')
const sass = require('gulp-sass')
const typescript = require('gulp-typescript')
const postcss = require('gulp-postcss')
const cssnano = require('cssnano')
const mqpacker = require('css-mqpacker')
const mqsort = require('sort-css-media-queries')
const focus = require('postcss-focus')
const newer = require('gulp-newer')
const shell = require('shelljs')
const bsync = require('browser-sync').create()
const filter = require('gulp-filter')

const bsConfig = require('./bs-config.js')
const tsConfig = require('./tsconfig.json')

const uglifyOpts = {output: {comments: /(^!|\@license|\@preserve)/i}}

const paths = {
    scripts: {
        src: tsConfig.include,
        dest: tsConfig.compilerOptions.outDir,
        mapDest: '.'
    },
    serve: {
        src: bsConfig.files
    },
    styles: {
        src: ['./assets/styles/**/*.scss'],
        dest: './dist/styles',
        mapDest: '.'
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
    src(paths.scripts.src, {sourcemaps: true})
        .pipe(newer(paths.scripts.dest))
        .pipe(typescript(tsConfig.compilerOptions))
        .pipe(uglify(uglifyOpts))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(paths.scripts.dest, {sourcemaps: paths.scripts.mapDest}))

    done()
}

function _styles(done)
{
    src(paths.styles.src, {sourcemaps: true})
        .pipe(newer(paths.styles.dest))
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([focus(), mqpacker({sort: mqsort}), cssnano()]))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(paths.styles.dest, {sourcemaps: paths.styles.mapDest}))
        .pipe(filter(['**/*.css']))
        .pipe(rtlcss())
        .pipe(rename(path =>
            path.basename = path.basename.replace('.min', '-rtl.min')
        ))
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

function _serve(done)
{
    bsync.init(bsConfig)

    done()
}

function _reload(done)
{
    bsync.reload()

    done()
}

function _watch(done)
{
    watch(paths.scripts.src, {ignoreInitial: false}, _scripts)
    watch(paths.styles.src, {ignoreInitial: false}, _styles)
    watch(paths.serve.src, {ignoreInitial: false}, _reload)

    done()
}

function _clean(done)
{
    shell.rm(
        '-rf',
        paths.styles.dest,
        paths.scripts.dest,
        paths.vendor.dest.dist,
        paths.vendor.dest.assets
    )

    done()
}

function _chmod(done)
{
    shell.chmod('-R', 'a+x', './bin', './vendor/bin', './node_modules/.bin')

    done()
}

exports.styles = _styles
exports.scripts = _scripts
exports.vendor = _vendor
exports.watch = _watch
exports.clean = _clean
exports.chmod = _chmod
exports.serve = _serve

exports.default = series(parallel(_styles, _scripts), _serve, _watch)
