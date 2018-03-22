///<reference path="./global.d.ts"/>

(($: JQueryStatic): void => {
    'use strict'

    /**
     * Footer credits
     */
    wp.customize(colophonModName, (value: () => void): void => {
        value.bind((to: string): void => {
            $('#colophon small').html(replaceShortTags(to))
        })
    })

    /**
     * Page Title
     */
    for (let i in titleModNames) {
        wp.customize(titleModNames[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('h1.page-title').html(replaceShortTags(to))
            })
        })
    }

    /**
     * Posts heading
     */
    for (let i in relatedPostsHeadingModNames) {
        wp.customize(relatedPostsHeadingModNames[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('#related-posts-wrap .posts-heading').html(to)
            })
        })
    }

    function replaceShortTags(content: string): string
    {
        for (let tag in shortTags) {
            content = content.split(tag).join(shortTags[tag])
        }

        return content
    }
})(jQuery)
