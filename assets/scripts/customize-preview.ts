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
    $.each(jentilPageTitleModIds, (i: number, id: string): void => {
        wp.customize(id, (value: () => void): void => {
            value.bind((to: string): void => {
                $('.page-title').html(replaceShortTags(to))
            })
        })
    })

    /**
     * Posts heading
     */
    $.each(jentilRelatedPostsHeadingModIds, (i: number, id: string): void => {
        wp.customize(id, (value: () => void): void => {
            value.bind((to: string): void => {
                $('#related-posts-wrap .posts-heading').html(to)
            })
        })
    })

    /**
     * Layout
     */
    $.each(jentilPageLayoutModIds, (i: number, id: string): void => {
        wp.customize(id, (value: () => void): void => {
            value.bind((to: string): void => {
                $('body').attr('class', (i: number, c: string): string =>
                    c.replace(/(^|\s)layout\-\S+/g, '')
                ).addClass(`layout-${to} layout-columns-${to.split('-').length}`)
            })
        })
    })

    function replaceShortTags(content: string): string
    {
        $.each(jentilShortTags, (tag: string, replace: string): void => {
            content = content.split(tag).join(replace)
        })

        return content
    }
})(jQuery)
