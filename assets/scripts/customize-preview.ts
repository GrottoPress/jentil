/// <reference path='./global.d.ts' />

((_wp: WP, $: JQueryStatic): void => {
    'use strict'

    const { customize } = _wp

    customize(jentilColophonModId, (from: () => void): void => {
        from.bind((to: string): void => {
            $('#colophon small').html(replaceShortTags(to))
        })
    })

    $.each(jentilPageTitleModIds, (i: number, id: string): void => {
        customize(id, (from: () => void): void => {
            from.bind((to: string): void => {
                $('.page-title').html(replaceShortTags(to))
            })
        })
    })

    $.each(jentilRelatedPostsHeadingModIds, (i: number, id: string): void => {
        customize(id, (from: () => void): void => {
            from.bind((to: string): void => {
                $('#related-posts-wrap .posts-heading').html(to)
            })
        })
    })

    $.each(jentilPageLayoutModIds, (i: number, id: string): void => {
        customize(id, (from: () => void): void => {
            from.bind((to: string): void => {
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
})(wp, jQuery)
