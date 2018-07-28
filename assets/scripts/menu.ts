/// <reference path='./global.d.ts' />

(($: JQueryStatic): void => {
    'use strict'

    const duration: number = 200

    /**
     * Toggle mobile menu
     */

    $('.js-main-menu-button').attr('href', '#').on(
        'click',
        (event: JQuery.Event): void => {
            $('.js-main-menu').slideToggle(duration, (): void => {
                $('.js-main-menu').toggleClass('show hide').css({display: ''})
            })

            event.preventDefault()
        }
    )

    /**
     * Add icons to all parent menu items
     */

    $('.menu li > ul').before(
        `<button class="js-sub-menu-button sub-menu-toggle">
            ${renderCaret('down')}
        </button>`
    )

    /**
     * Toggle sub-menu
     */

    $('.js-sub-menu-button').next('ul').hide()
    $('.site-sidebar li.current-menu-ancestor > ul').show()
        .siblings('.js-sub-menu-button').html(`${renderCaret('up')}`)

    $('.js-sub-menu-button').prev('a').on(
        'click',
        (event: JQuery.Event): void => {
            if ('#' === $(event.currentTarget).attr('href')) {
                toggleSubMenu($(event.currentTarget).next('button'))

                event.preventDefault()
            }
        }
    )

    $('.js-sub-menu-button').on('click', (event: JQuery.Event): void => {
        toggleSubMenu(event.currentTarget)

        event.preventDefault()
    })

    /**
     * Helpers
     */

    function toggleSubMenu(
        button: JQuery<EventTarget> | HTMLElement | EventTarget,
        effect = (target:
            JQuery<EventTarget |
            HTMLElement |
            JQuery<EventTarget>>
        ): void => {
            $(target).slideToggle(duration)
        }
    ): void {
        $(button).parent().siblings('li').children('ul').slideUp(duration)
        $(button).parent().siblings('li').children('button').html(
            renderCaret('down')
        )

        toggleCaret(button)

        effect($(button).next('ul'))
    }

    function toggleCaret(button:
        JQuery<EventTarget> |
        HTMLElement | EventTarget
    ): void {
        if ('none' === $(button).next('ul').css('display')) {
            $(button).html(renderCaret('up'))
        } else {
            $(button).html(renderCaret('down'))
        }
    }

    function renderCaret(direction: 'up' | 'down'): string
    {
        return `<span class="fas fa-caret-${direction.toString()} fa-sm" aria-hidden="true"></span>
        <span class="screen-reader-text">${jentilMenuL10n.submenu}</span>`
    }
})(jQuery)
