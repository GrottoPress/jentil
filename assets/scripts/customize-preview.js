/**
 * Customizer
 * 
 * Handles postMessage transport, allowing changes to take
 * effect immediately without page reload
 *
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

(function ($) {
    'use strict';
    
    /**
     * Footer credits
     *
     * @since 0.1.0
     */
    wp.customize(colophonModName, function (value) {
        value.bind(function (to) {
            $('#colophon small').html(replaceShortTags(to));
        });
    });

    /**
     * Page Title
     *
     * @since 0.5.0
     *
     * @todo Work out how to replace tags
     */
    for (var i in titleModNames) {
        wp.customize(titleModNames[i], function (value) {
            value.bind(function (to) {
                $('h1.page-title').html(to);
            });
        });
    }

    /**
     * Replace Shortags
     *
     * @param {string} content
     *
     * @since 0.5.0
     * @global [shortTags] Passed in via PHP
     *
     * @return {string}
     */
    function replaceShortTags(content) {
        for (var tag in shortTags) {
            content = content.split(tag).join(shortTags[tag]);
        }

        return content;
    }
})(jQuery);
