/// <reference path="./global.d.ts" />

(($: JQueryStatic): void => {
    'use strict'

    /**
     * Add has-js class to `<body>` tag
     */
    $('body').removeClass('no-js').addClass('has-js')
})(jQuery)
