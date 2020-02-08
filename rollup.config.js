'use strict'

const flatten = require('flatten')
const glob = require('glob')
const typescript = require('@rollup/plugin-typescript')
const tsConfig = require('./tsconfig.json')

module.exports = {
    input: flatten(tsConfig.include.map(pattern => glob.sync(pattern)))
        .filter(filename => !filename.endsWith('.d.ts')),
    output: {
        dir: tsConfig.compilerOptions.outDir,
        format: 'iife',
        name: 'Jentil'
    },
    plugins: [typescript(tsConfig.compilerOptions)]
}
