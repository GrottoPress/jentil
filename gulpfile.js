'use strict'

const gulp = require('gulp')
const uglify = require('gulp-uglify')
const rename = require('gulp-rename')
const rtlcss = require('gulp-rtlcss')
const cleanCSS = require('gulp-clean-css')
const sass = require('gulp-sass')
const sourcemaps = require('gulp-sourcemaps')
const typescript = require('gulp-typescript')
const concat = require('gulp-concat')

const scripts_src = ['./assets/scripts/**/*.ts']
const scripts_dest = './dist/scripts'
const styles_src = ['./assets/styles/**/*.scss']
const styles_dest = './dist/styles'
const vendor_dist = './dist/vendor'
const vendor_assets = './assets/vendor'

gulp.task('scripts', () =>
    gulp.src(scripts_src)
        .pipe(sourcemaps.init())
        .pipe(typescript({
            "module": "commonjs",
            "target": "es5",
            "noImplicitAny": true,
            "noImplicitUseStrict": true,
            "noImplicitThis": true,
            "strictNullChecks": true,
            "strictFunctionTypes": true
        }))
        .pipe(uglify())
        .pipe(rename({'suffix' : '.min'}))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(scripts_dest))
)

gulp.task('styles', () =>
    gulp.src(styles_src)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        // .pipe(cleanCSS({format: 'beautify'}))
        // .pipe(gulp.dest(styles_dest))
        .pipe(cleanCSS())
        .pipe(rename({'suffix' : '.min'}))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(styles_dest))
        .pipe(rtlcss())
        .pipe(rename((path) =>
            path.basename = path.basename.replace('.min', '-rtl.min')
        ))
        .pipe(gulp.dest(styles_dest))
)

gulp.task('vendor', () => {
    gulp.src([
        './vendor/grottopress/wordpress-posts/dist/styles/*.min.css',
        './node_modules/html5shiv/dist/html5shiv.min.js',
        './node_modules/respond.js/dest/respond.min.js',
        './node_modules/what-input/dist/what-input.min.js'
    ]).pipe(gulp.dest(vendor_dist))

    gulp.src(['./node_modules/normalize.css/normalize.css'])
        .pipe(cleanCSS())
        .pipe(rename({'suffix' : '.min'}))
        .pipe(gulp.dest(vendor_dist))

    gulp.src([
        './node_modules/@fortawesome/fontawesome/index.js',
        './node_modules/@fortawesome/fontawesome-free-solid/index.js',
        './node_modules/@fortawesome/fontawesome-free-regular/index.js',
        './node_modules/@fortawesome/fontawesome-free-brands/index.js'
    ])
        .pipe(concat('fontawesome.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(vendor_dist))

    gulp.src(['./node_modules/@grottopress/scss/**'])
        .pipe(gulp.dest(`${vendor_assets}/@grottopress/scss`))
})

gulp.task('watch', () => {
    gulp.watch(scripts_src, ['scripts'])
    gulp.watch(styles_src, ['styles'])
})

gulp.task('default', [
    'scripts',
    'styles',
    'watch'
])
