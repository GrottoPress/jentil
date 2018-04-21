/// <reference path="./global.d.ts" />

(($: JQueryStatic): void => {
    'use strict'

    /**
     * Footer credits
     */
    wp.customize(jentilColophonModId, (value: () => void): void => {
        value.bind((to: string): void => {
            $('#colophon small').html(replaceShortTags(to))
        })
    })

    /**
     * Page Title
     */
    for (let i in jentilTitleModIds) {
        wp.customize(jentilTitleModIds[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('#page-title').html(replaceShortTags(to))
            })
        })
    }

    /**
     * Posts heading
     */
    for (let i in jentilRelatedPostsHeadingModIds) {
        wp.customize(jentilRelatedPostsHeadingModIds[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('#related-posts-wrap .posts-heading').html(to)
            })
        })
    }

    function replaceShortTags(content: string): string
    {
        for (let tag in jentilShortTags) {
            content = content.split(tag).join(jentilShortTags[tag])
        }

        return content
    }
})(jQuery)
