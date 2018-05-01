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
    for (let i in jentilPageTitleModIds) {
        wp.customize(jentilPageTitleModIds[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('.page-title').html(replaceShortTags(to))
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

    /**
     * Layout
     */
    for (let i in jentilPageLayoutModIds) {
        wp.customize(jentilPageLayoutModIds[i], (value: () => void): void => {
            value.bind((to: string): void => {
                $('body').attr('class', (i: number, c: string): string =>
                    c.replace(/(^|\s)layout\-\S+/g, '')
                ).addClass(`layout-${to} layout-columns-${to.split('-').length}`)
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
