/**
 * Menus
 *
 * Handles the behaviour of menu items
 *
 * @since 0.5.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

(function ($) {
    'use strict';

    var fxDuration = 200;

    /**
     * Mobile menu button
     *
     * @since 0.1.0
     */
    $('.js-main-menu-button').attr('href', '#');
    $('.js-main-menu-button').on('click', function (e) {
        $('.js-main-menu').slideToggle(fxDuration);

        e.preventDefault();
    });

    /**
     * Add icons to all parent menu items
     *
     * @since 0.1.0
     */
    $('.menu li > ul').before(
        '<button class="js-sub-menu-button sub-menu-toggle">'+
            renderCaret('down')+
        '</button>'
    );

    /**
     * Sub-menu button
     *
     * @since 0.1.0
     */
    $('.js-sub-menu-button').next('ul').hide();
    $('.js-sub-menu-button').prev('a').on('click', function (e) {
        if ('#' === $(this).attr('href')) {
            toggleSubMenu($(this).next('button'));

            e.preventDefault();
        }
    });
    $('.js-sub-menu-button').on('click', function (e) {
        toggleSubMenu(this);

        e.preventDefault();
    });

    /**
     * Toggle Submenu
     *
     * @param {string} button
     *
     * @return {string}
     */
    function toggleSubMenu(button)
    {
        var activeClass = 'active';
        
        $(button).parent().toggleClass(activeClass);
        $(button).parent().siblings('li').children('ul').slideUp(fxDuration);
        $(button).parent().siblings('li').children('button').html(
            renderCaret('down')
        );

        toggleCaret(button);

        $(button).next('ul').toggleClass(activeClass).slideToggle(fxDuration);
    }

    /**
     * Toggle Caret
     *
     * To be called BEFORE opening submenu.
     *
     * @param {string} button
     */
    function toggleCaret(button)
    {
        if ('none' === $(button).next('ul').css('display')) {
            $(button).html(renderCaret('up'));
        } else {
            $(button).html(renderCaret('down'));
        }
    }

    /**
     * Up/Down button HTML
     * 
     * @param {string} direction 'up' or 'down'
     * 
     * @return {string}
     */
    function renderCaret(direction)
    {
        return '<span class="fa fa-caret-'+direction.toString()+
            '" aria-hidden="true"></span>'+
            '<span class="screen-reader-text">Sub-menu</span>';
    }
})(jQuery);
