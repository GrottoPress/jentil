/**
 * Menus
 *
 * Handles the behaviour of menu items
 *
 * @since 0.1.0
 */

(function ($) {
    'use strict';

    // Mobile menu button
    $('.js-mobile-menu').hide();
    $('.js-mobile-menu-button').attr('href', '#');
    $('.js-mobile-menu-button').on('click', function (e) {
        $('.js-mobile-menu').slideToggle({
            'duration': 200
        });

        e.preventDefault();
    });

    // Add icons to all parent menu items
    $('.menu li > ul').before('<button class="js-sub-menu-button sub-menu-toggle closed">'+renderCaret('down')+'</button>');

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
    function toggleSubMenu(selector)
    {
        $(selector).toggleClass('closed');

        $(selector).parent().siblings('li').children('ul').hide();
        toggleCaretAlt($(selector).parent().siblings('li').children('button'));

        $(selector).next('ul').slideToggle({
            'duration': 200
        }); // override `display:none;` in CSS for hover
        toggleCaret(selector);
    }

    // Toggle Caret
    function toggleCaret(selector)
    {
        var html = $(selector).html();

        if (html.indexOf('fa-caret-up') >= 0) {
            $(selector).html(renderCaret('down'));
        } else {
            $(selector).html(renderCaret('up'));
        }
    }

    // Toggle Caret
    function toggleCaretAlt(selector)
    {
        if ('none' === $(selector).next('ul').css('display')) {
            $(selector).html(renderCaret('down'));
        } else {
            $(selector).html(renderCaret('up'));
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
