'use strict'

const typescript = require('@rollup/plugin-typescript')
const tsConfig = require('./tsconfig.json')

module.exports = {
    // We're running rollup via gulp, so globs are OK.
    input: ['./assets/scripts/*.ts'],
    output: {
        dir: tsConfig.compilerOptions.outDir,
        format: 'iife',
        name: 'Jentil'
    },
    plugins: [typescript(tsConfig.compilerOptions)]
}
