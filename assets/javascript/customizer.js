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
     * Layout
     */
    
    /*var bodyClasses = $( 'body' ).attr( 'class' ).split( ' ' );
    var bodyClassesNum = bodyClasses.length;
    
    var dynamic = 'wont-work';
    var dynamicClass = 'wont-work';
    var initialColumnsClass = '';
    var initialLayoutClass = '';
    
    if ( bodyClassesNum > 0 ) {
        for ( var i = 0; i < bodyClassesNum; i++ ) {
            var thisBodyClass = bodyClasses[ i ];
            
            if ( thisBodyClass.indexOf( 'tax-' ) >= 0 ) {
                dynamicClass = thisBodyClass;
                dynamic = thisBodyClass.replace( 'tax-', '' ) + '_taxonomy_archive_layout';
                break;
            } else if ( thisBodyClass.indexOf( 'single-' ) >= 0 && thisBodyClass.indexOf( 'single-format-' ) < 0 ) {
                dynamicClass = thisBodyClass;
                dynamic = 'single_' + thisBodyClass.replace( 'single-', '' ) + '_layout';
                break;
            } else if ( thisBodyClass.indexOf( 'post-type-archive-' ) >= 0 ) {
                dynamicClass = thisBodyClass;
                dynamic = thisBodyClass.replace( 'post-type-archive-', '' ) + '_post_type_archive_layout';
                break;
            }
            
            if ( thisBodyClass.indexOf( '-columns' ) ) {
                initialColumnsClass = thisBodyClass;
            } else if ( thisBodyClass.indexOf( 'layout-' ) ) {
                initialLayoutClass = thisBodyClass;
            }
        }
    }
    
    // Hide sidebars initially, depending on layout
    switch ( initialLayoutClass ) {
        case 'layout-one-column':
            $( '.site-sidebar' ).hide();
            break;
        case 'layout-three-columns':
            $( '.site-sidebar' ).show();
            break;
        default:
            $( '#secondary.site-sidebar' ).hide();
            $( '#primary.site-sidebar' ).show();
            break;
    }
    
    var templates = {
        'post_archive_layout': 'blog',
		'author_archive_layout': 'author',
		'category_archive_layout': 'category',
		'date_archive_layout': 'date',
		'tag_archive_layout': 'tag',
		'error_404_layout': 'error404',
		'search_layout': 'search'
	};
	templates[ dynamic ] = dynamicClass;
	
	for ( var key in templates ) {
        if ( ! templates.hasOwnProperty( key ) ) {
            continue;
        }
        
        if ( 'wont-work' === key || 'wont-work' === templates[ key ] ) {
            continue;
        }
        
        var bodySelector = 'body.' + templates[ key ];
        
        if ( $( bodySelector ).length > 0 ) {
            wp.customize( key, function( value ) {
                value.bind( function( to ) {
                    var toColumns = to.toString().split( '-' ).length;
                    var columnsClass;
                    
                    switch ( toColumns ) {
                        case 1:
                            columnsClass = 'one-column';
                            $( '.site-sidebar' ).hide();
                            break;
                        case 3:
                            columnsClass = 'three-columns';
                            $( '.site-sidebar' ).show();
                            break;
                        default:
                            columnsClass = 'two-columns';
                            $( '#secondary.site-sidebar' ).hide();
                            $( '#primary.site-sidebar' ).show();
                            break;
                    }
                    
                    $( bodySelector ).removeClass( initialLayoutClass + ' ' + initialColumnsClass ).addClass( 'layout-' + to.toString() + ' layout-' + columnsClass );
                });
            });
            
            break;
        }
	}*/
	
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
    //         var logo = $( '.jentil-logo-link .custom-logo' );
    //         var width = logo.attr( 'data-width' );
    //         var height = logo.attr( 'data-height' );
    //         var src = logo.attr( 'data-src' );
    //         var alt = logo.attr( 'data-alt' );
            
    //         $( '.jentil-logo-link' ).removeAttr( 'style' ).html( '<img class="custom-logo" width="' + width + '" height="' + height + '" src="' + src + '" alt="' + alt + '" itemprop="logo" />' );
    //     });
    // });
})( jQuery );