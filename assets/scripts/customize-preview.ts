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

(($: JQueryStatic): void => {
    'use strict'

    /**
     * Footer credits
     *
     * @since 0.6.0
     */
    wp.customize(colophonModName, (value: () => void): void => {
        value.bind((to: string): void => {
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
    for (let i in titleModNames) {
        wp.customize(titleModNames[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('h1.page-title').html(to)
            })
        })
    }

    /**
     * Posts heading
     *
     * @since 0.6.0
     */
    for (let i in relatedPostsHeadingModNames) {
        wp.customize(relatedPostsHeadingModNames[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('#related-posts-wrap .posts-heading').html(to)
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
        for (let tag in shortTags) {
            content = content.split(tag).join(shortTags[tag])
        }

        return content
    }
})(jQuery)
