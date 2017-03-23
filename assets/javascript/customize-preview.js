/**
 * Theme's customizer
 * 
 * Handles postMessage transport, allowing changes to take
 * effect immediately without page reload
 * 
 * References:
 * 
 * - http://stackoverflow.com/questions/921789/how-to-loop-through-plain-javascript-object-with-objects-as-members#921808
 * - http://stackoverflow.com/questions/3480771/how-do-i-check-if-string-contains-substring#3480785
 */

(function( $ ) {
    'use strict';
	
	/**
	 * Footer credits
	 */
	
	wp.customize( 'colophon', function( value ) {
        value.bind( function( to ) {
            var homeUrl = window.location.protocol + "//" + window.location.host + "/";
            var currentYear = new Date().getFullYear();
            var siteName = $( 'html' ).attr( 'data-site-name' );
            var siteDescription = $( 'html' ).attr( 'data-site-description' );
            
            $( '#colophon small' ).html( to.replace( '{{site_url}}', homeUrl ).replace( '{{site_name}}', siteName ).replace( '{{this_year}}', currentYear ).replace( '{{site_description}}', siteDescription ) );
        });
    });
    
    /**
     * Logo
     */
    
    // wp.customize( 'custom_logo', function( value ) {
    //     value.bind( function( to ) {
    //         var logo = $( '.custom-logo-link .custom-logo' );
    //         var width = logo.attr( 'data-width' );
    //         var height = logo.attr( 'data-height' );
    //         var src = logo.attr( 'data-src' );
    //         var alt = logo.attr( 'data-alt' );
            
    //         $( '.custom-logo-link' ).removeAttr( 'style' ).html( '<img class="custom-logo" width="' + width + '" height="' + height + '" src="' + src + '" alt="' + alt + '" itemprop="logo" />' );
    //     });
    // });
})( jQuery );