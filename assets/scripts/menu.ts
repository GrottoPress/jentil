/**
 * Menus
 *
 * Handles the behaviour of menu items
 *
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

///<reference path="./global.d.ts"/>

(($: JQueryStatic): void => {
    'use strict'

    const fxDuration = 200

    /**
     * Mobile menu button
     *
     * @since 0.6.0
     */
    $('.js-main-menu-button').attr('href', '#')
    $('.js-main-menu-button').on('click', (e: JQuery.Event): void => {
        $('.js-main-menu').slideToggle(fxDuration, (): void => {
            $(e.currentTarget).toggleClass('show hide').css({display: ''})
        })

        e.preventDefault()
    })

    /**
     * Add icons to all parent menu items
     *
     * @since 0.6.0
     */
    $('.menu li > ul').before(
        '<button class="js-sub-menu-button sub-menu-toggle">'+
            renderCaret('down')+
        '</button>'
    )

    /**
     * Sub-menu button
     *
     * @since 0.6.0
     */
    $('.js-sub-menu-button').next('ul').hide()
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

    /**
     * Toggle Submenu
     *
     * @since 0.6.0
     *
     * @param {string} button
     *
     * @return {string}
     */
    function toggleSubMenu(button: JQuery | HTMLElement | EventTarget): void
    {
        $(button).parent().siblings('li').children('ul').slideUp(fxDuration)
        $(button).parent().siblings('li').children('button').html(
            renderCaret('down')
        )

        toggleCaret(button)

        $(button).next('ul').slideToggle(fxDuration)
    }

    /**
     * Toggle Caret
     *
     * @since 0.6.0
     *
     * To be called BEFORE opening submenu.
     *
     * @param {string} button
     */
    function toggleCaret(button: JQuery | HTMLElement | EventTarget): void
    {
        if ('none' === $(button).next('ul').css('display')) {
            $(button).html(renderCaret('up'))
        } else {
            $(button).html(renderCaret('down'))
        }
    }

    /**
     * Up/Down button HTML
     *
     * @since 0.6.0
     * 
     * @param {string} direction 'up' or 'down'
     * 
     * @return {string}
     */
    function renderCaret(direction: 'up' | 'down'): string
    {
        return '<span class="fa fa-caret-'+direction.toString()+
            '" aria-hidden="true"></span>'+
            '<span class="screen-reader-text">Sub-menu</span>'
    }
})(jQuery)
