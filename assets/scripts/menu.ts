/// <reference path="./global.d.ts" />

(($: JQueryStatic): void => {
    'use strict'

    const fxDuration: number = 200

    /**
     * Open/close mobile menu
     */
    $('.js-main-menu-button').attr('href', '#').on(
        'click',
        (event: JQuery.Event): void => {
            $('.js-main-menu').slideToggle(fxDuration, (): void => {
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
     * Open/close sub-menu
     */
    $('.js-sub-menu-button').next('ul').hide()
    $('.sidebar-wrap li.current-menu-ancestor > ul').show()
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

    function toggleSubMenu(button: JQuery | HTMLElement | EventTarget): void
    {
        $(button).parent().siblings('li').children('ul').slideUp(fxDuration)
        $(button).parent().siblings('li').children('button').html(
            renderCaret('down')
        )

        toggleCaret(button)

        $(button).next('ul').slideToggle(fxDuration)
    }

    function toggleCaret(button: JQuery | HTMLElement | EventTarget): void
    {
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
