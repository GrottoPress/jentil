/**
 * Customizer
 * 
 * Handles postMessage transport, allowing changes to take
 * effect immediately without page reload
 *
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

///<reference path="./global.d.ts"/>

(($: JQueryStatic) => {
    'use strict'

    /**
     * Footer credits
     *
     * @since 0.6.0
     */
    wp.customize(colophonModName, (value: any) => {
        value.bind((to: string) => {
            $('#colophon small').html(replaceShortTags(to))
        })
    })

    /**
     * Page Title
     *
     * @since 0.6.0
     *
     * @todo Work out how to replace tags
     */
    for (var i in titleModNames) {
        wp.customize(titleModNames[i], (value: any) => {
            value.bind((to: string) => {
                $('h1.page-title').html(to)
            })
        })
    }

    /**
     * Replace Shortags
     *
     * @param {string} content
     *
     * @since 0.6.0
     * @global [shortTags] Passed in via PHP
     *
     * @return {string}
     */
    function replaceShortTags(content: string): string {
        for (var tag in shortTags) {
            content = content.split(tag).join(shortTags[tag])
        }

        return content
    }
})(jQuery)
