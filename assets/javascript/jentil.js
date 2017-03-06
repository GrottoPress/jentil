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
        }); // override `display:none;` in CSS for hover
    }

    // Make the mobile menu button work
    $( '.js-mobile-menu' ).hide();
	$( '.js-mobile-menu-button' ).on( 'click', function( event ) {
        event.preventDefault();
        
        $( '.js-mobile-menu' ).slideToggle({
            'duration': 200
        });
    });
    
    // Add icons to all parent menu items
    $( '.menu li > ul' ).before( '<button role="button" class="js-sub-menu-button sub-menu-toggle closed"><span class="fa fa-caret-down" aria-hidden="true"></span><span class="screen-reader-text">Sub-menu</span></button>' );
    
    // Sub-menus toggle
    $( '.js-sub-menu-button' ).next( 'ul' ).hide();
    $( '.js-sub-menu-button' ).prev( 'a' ).on( 'click', function( event ) {
        if ( '#' == $( this ).attr( 'href' ) ) {
            event.preventDefault();

            subMenuToggle( $( this ).next( 'button' ) );
        }
    });
    $( '.js-sub-menu-button' ).on( 'click', function( event ) {
        event.preventDefault();

        subMenuToggle( this );
    });
})( jQuery );