(function( $ ) {
    'use strict';
    
    var bodyClass = $( 'body' ).attr( 'class' );
    var bodyClasses = bodyClass.split( ' ' );
    var bodyClassesNum = bodyClasses.length;
    
    var taxClass = 'wont-work';
    var postTypeClass = 'wont-work';
    var postType = 'wont-work';
    
    //if ( bodyClassesNum > 0 ) {
        for ( var i = 0; i < bodyClassesNum; i++ ) {
            var thisBodyClass = bodyClasses[ i ];
            
            // Ref: http://stackoverflow.com/questions/3480771/how-do-i-check-if-string-contains-substring#3480785
            if ( thisBodyClass.indexOf( 'tax-' ) >= 0 ) {
                taxClass = thisBodyClass;
                break;
            } else if ( thisBodyClass.indexOf( 'single-' ) >= 0 && thisBodyClass.indexOf( 'single-format-' ) < 0 ) {
                postTypeClass = thisBodyClass;
                postType = thisBodyClass.replace( 'single-', '' );
                break;
            }
        }
    //}
    
    // Templates and their body classes
    var templates = {
        'home': 'blog',
		'author': 'author',
		'category': 'category',
		'date': 'date',
		'post_type_archive': 'post-type-archive',
		'tag': 'tag',
		'404': 'error404',
		'search': 'search'
	};
	
	templates[ postType ] = postTypeClass;
	templates['tax'] = taxClass;
	
	for ( var key in templates ) {
        // Ref: http://stackoverflow.com/questions/921789/how-to-loop-through-plain-javascript-object-with-objects-as-members#921808
        if ( ! templates.hasOwnProperty( key ) ) {
            continue;
        }
        
        if ( 'wont-work' == key || 'wont-work' == templates[ key ] ) {
            continue;
        }
        
        var checkBodyClass = 'body.' + templates[ key ];
        //console.log( key + ' : ' + checkBodyClass );
        var setting = key + '_layout';
        
        wp.customize( setting, function( value ) {
            value.bind( function( to ) {
                var toColumns = to.split( '-' ).length;
                var columnsClass;
                
                switch ( toColumns ) {
                    case 1:
                        columnsClass = 'one-column';
                        break;
                    case 3:
                        columnsClass = 'three-columns';
                        break;
                    default:
                        columnsClass = 'two-columns';
                        break;
                }
                
                $( checkBodyClass ).removeClass( 'layout-content-sidebar layout-sidebar-content layout-content-sidebar-sidebar layout-sidebar-sidebar-content layout-sidebar-content-sidebar layout-content layout-one-column layout-two-columns layout-three-columns' ).addClass( 'layout-' + to.toString() + ' layout-' + columnsClass );
            });
        });
	}
})( jQuery );