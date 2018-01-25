/**
 * Jentil
 *
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

///<reference path="./global.d.ts"/>

(($: JQueryStatic): void => {
    'use strict'

    /**
     * Add has-js class to `<body>` tag
     *
     * @since 0.6.0
     */
    $('body').removeClass('has-js no-js').addClass('has-js')
})(jQuery)
