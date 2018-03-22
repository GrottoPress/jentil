///<reference path="./global.d.ts"/>

(($: JQueryStatic): void => {
    'use strict'

    /**
     * Footer credits
     */
    wp.customize(jentilColophonModName, (value: () => void): void => {
        value.bind((to: string): void => {
            $('#colophon small').html(replaceShortTags(to))
        })
    })

    /**
     * Page Title
     */
    for (let i in jentilTitleModNames) {
        wp.customize(jentilTitleModNames[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('h1.page-title').html(replaceShortTags(to))
            })
        })
    }

    /**
     * Posts heading
     */
    for (let i in jentilRelatedPostsHeadingModNames) {
        wp.customize(jentilRelatedPostsHeadingModNames[i], (value: () => void): void => {
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
