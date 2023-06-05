let mix = require('laravel-mix')
let path = require('path')
let rtlcss = require('rtlcss')

let bsConfig = require('./bs-config')

mix.setResourceRoot('../')
mix.setPublicPath(path.resolve('./'))

mix.disableNotifications()

mix.webpackConfig({
    watchOptions: { ignored: [
        path.posix.resolve(__dirname, './node_modules'),
        path.posix.resolve(__dirname, './dist'),
    ] }
})

mix.ts('assets/js/core.ts', 'dist/js').sourceMaps()
mix.ts('assets/js/customize-preview.ts', 'dist/js').sourceMaps()
mix.ts('assets/js/menu.ts', 'dist/js').sourceMaps()

mix.postCss('assets/css/core.css', 'dist/css').sourceMaps()
mix.postCss('assets/css/editor.css', 'dist/css').sourceMaps()

mix.postCss(
    'assets/css/core-rtl.css',
    'dist/css',
    [rtlcss()]
).sourceMaps()

mix.postCss(
    'assets/css/editor-rtl.css',
    'dist/css',
    [rtlcss()]
).sourceMaps()

mix.copy('vendor/grottopress/wordpress-posts/dist/css/posts.css', 'dist/vendor')
mix.copy(
    'vendor/grottopress/wordpress-posts/dist/css/posts-rtl.css',
    'dist/vendor'
)

mix.copy('node_modules/html5shiv/dist/html5shiv.min.js', 'dist/vendor')
mix.copy('node_modules/what-input/dist/what-input.min.js', 'dist/vendor')
mix.copy('node_modules/jquery/dist/jquery.min.js', 'dist/vendor')

mix.copy('node_modules/respond.js/dest/respond.min.js', 'dist/vendor')

mix.copy(
    'node_modules/jquery-migrate/dist/jquery-migrate.min.js',
    'dist/vendor'
)

mix.copy(
    'node_modules/@fortawesome/fontawesome-free/js/all.min.js',
    'dist/vendor/font-awesome.min.js'
)

mix.copy(
    'node_modules/@fortawesome/fontawesome-free/js/v4-shims.min.js',
    'dist/vendor/font-awesome-v4-shims.min.js'
)

mix.browserSync(bsConfig)

if (mix.inProduction()) {
    mix.version()
} else {
    Mix.manifest.refresh = _ => void 0
}
