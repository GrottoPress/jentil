module.exports = {
    // browser: ['google chrome', 'firefox'],
    files: [
        './dist/styles/**/*',
        './dist/scripts/**/*',
        './app/partials/**/*',
        './app/templates/**/*',
        './app/libraries/Jentil/Setups/Views/**/*'
    ],
    minify: false,
    // notify: true,
    // open: false,
    // port: 3000,
    proxy: 'localhost',
    reloadDebounce: 3000
    // reloadDelay: 0,
}
