/// <reference path="./global.d.ts" />

(($: JQueryStatic): void => {
    'use strict'

    const fxDuration = 200

    /**
     * Open/close mobile menu
     */
    $('.js-main-menu-button').attr('href', '#')
    $('.js-main-menu-button').on('click', (e: JQuery.Event): void => {
        $('.js-main-menu').slideToggle(fxDuration, (): void => {
            $('.js-main-menu').toggleClass('show hide').css({display: ''})
        })

        e.preventDefault()
    })

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
    $('.sidebar-wrap li.current-menu-ancestor > .sub-menu-toggle').html(
        `${renderCaret('up')}`
    )
    $('.js-sub-menu-button').prev('a').on('click', (e: JQuery.Event): void => {
        if ('#' === $(e.currentTarget).attr('href')) {
            toggleSubMenu($(e.currentTarget).next('button'))

            e.preventDefault()
        }
    })
    $('.js-sub-menu-button').on('click', (e: JQuery.Event): void => {
        toggleSubMenu(e.currentTarget)

        e.preventDefault()
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
