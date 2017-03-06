/**
 * Menus
 * 
 * Handles the behaviour of menu items
 * 
 * References:
 * 
 * - http://api.jquery.com/slidetoggle/
 * - http://stackoverflow.com/questions/6752677/use-jquery-to-automatically-add-arrows-to-all-parent-menus
 */

(function( $ ) {
    'use strict';

    /**
     * Add has-js class to `<html>` tag
     */

    $( 'html' ).removeClass( 'has-js' ).addClass( 'has-js' );

    /**
     * Mobile Menu
     */
    
    function subMenuToggle( selector ) {
        var html = $( selector ).html();

        if ( html.indexOf( 'fa-caret-up' ) >= 0 ) {
            $( selector ).html( '<span class="fa fa-caret-down" aria-hidden="true"></span><span class="screen-reader-text">Sub-menu</span>' );
        } else {
            $( selector ).html( '<span class="fa fa-caret-up" aria-hidden="true"></span><span class="screen-reader-text">Sub-menu</span>' );
        }
        
        $( selector ).toggleClass( 'closed' );
        $( selector ).next( 'ul' ).slideToggle({
            'duration': 200
        }).css({ 'display':'block' }); // override `display:none;` in CSS for hover
    }

    // Make the mobile menu work
    $( '.site-navigation.screen-max-wide' ).hide();
	$( '.hamburger.menu-item' ).on( 'click', function( event ) {
        event.preventDefault();
        
        $( '.site-navigation.screen-max-wide' ).slideToggle({
            'duration': 200
        }).css({ 'display':'block' }); // override `display:none;` in CSS for hover
    });
    
    // Add icons to all parent menu items
    $( '.menu li > ul' ).before( '<button role="button" class="sub-menu-toggle closed"><span class="fa fa-caret-down" aria-hidden="true"></span><span class="screen-reader-text">Sub-menu</span></button>' );
    
    // Sub-menus toggle
    $( '.sub-menu-toggle' ).next( 'ul' ).hide();
    $( '.sub-menu-toggle' ).prev( 'a' ).on( 'click', function( event ) {
        if ( '#' == $( this ).attr( 'href' ) ) {
            event.preventDefault();

            subMenuToggle( $( this ).next( 'button' ) );
        }
    });
    $( '.sub-menu-toggle' ).on( 'click', function( event ) {
        event.preventDefault();

        subMenuToggle( this );
    });
})( jQuery );