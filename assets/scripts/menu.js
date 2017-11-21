/**
 * Menus
 *
 * Handles the behaviour of menu items
 *
 * @since 0.1.0
 */

(function ($) {
    'use strict';

    var fxDuration = 200;

    // Mobile menu button
    $('.js-mobile-menu').hide();
    $('.js-mobile-menu-button').attr('href', '#');
    $('.js-mobile-menu-button').on('click', function (e) {
        $('.js-mobile-menu').slideToggle(fxDuration);
        e.preventDefault();
    });

    // Add icons to all parent menu items
    $('.menu li > ul').before('<button class="js-sub-menu-button sub-menu-toggle">'+renderCaret('down')+'</button>');

    // Sub-menu button
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

    // Toggle Submenu
    function toggleSubMenu(button)
    {
        $(button).parent().toggleClass('active');
        $(button).parent().siblings('li').children('ul').slideUp(fxDuration);
        $(button).parent().siblings('li').children('button').html(
            renderCaret('down')
        );
        toggleCaret(button);
        $(button).next('ul').toggleClass('active').slideToggle(fxDuration);
    }

    // Toggle Caret
    // To be called BEFORE opening submenu.
    function toggleCaret(button)
    {
        if ('none' === $(button).next('ul').css('display')) {
            $(button).html(renderCaret('up'));
        } else {
            $(button).html(renderCaret('down'));
        }
    }

    // Up/Down button HTML
    function renderCaret(direction)
    {
        return '<span class="fa fa-caret-'+direction.toString().toLowerCase()+
            '" aria-hidden="true"></span>'+
            '<span class="screen-reader-text">Sub-menu</span>';
    }
})(jQuery);
