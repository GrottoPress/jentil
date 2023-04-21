module.exports = {
    // browser: ['google chrome', 'firefox'],
    files: [
        './dist/css/**/*',
        './dist/js/**/*',
        './app/partials/**/*',
        './app/templates/**/*',
        './app/libraries/Jentil/Setups/Views/**/*'
    ],
    minify: false,
    // notify: true,
    // open: false,
    // port: 3000,
    proxy: 'http://wordpress.localhost:8080',
    reloadDebounce: 3000
    // reloadDelay: 0,
}
