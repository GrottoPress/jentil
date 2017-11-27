#!/bin/bash
#
# Move production assets from 'node_modules/'' to 'dist/vendor/'

TO='./dist/vendor'
FROM=('normalize.css' 'font-awesome' 'html5shiv' 'respond.js')

[[ ! -d $TO ]] && mkdir -p $TO

for dir in ${FROM[@]}; do
    cp -rf ./node_modules/$dir ${TO}
done
