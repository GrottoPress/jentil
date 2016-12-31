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
    
    // Make the mobile menu work
    
    $( 'nav.menu-max-screen-920' ).hide();
	$( '.hamburger.menu-item' ).on( 'click', function( event ) {
        event.preventDefault();
        
        $( 'nav.menu-max-screen-920' ).slideToggle({
            'duration': 200
        });
    });
    
    // Add icons to all parent menu items
    
    $( '.menu' ).addClass( 'has-js' );
    
    $( '.menu li > ul' ).before( '<button role="button" class="sub-menu-toggle closed"><span class="screen-reader-text">Menu</span></button>' );
    
    $( '.sub-menu-toggle' ).next( 'ul' ).hide();
    $( '.sub-menu-toggle' ).on( 'click', function( event ) {
        event.preventDefault();
        
        $( this ).toggleClass( 'closed' );
        $( this ).next( 'ul' ).slideToggle({
            'duration': 200
        });
    });
})( jQuery );