<?php

/**
 * Index Template
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when no specific template matches a query.
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( version_compare( JENTIL_REQUIRED_PHP, phpversion(), '<=' )
    && version_compare( JENTIL_REQUIRED_WP, get_bloginfo( 'version' ), '<=' ) ) :

/**
 * Load template
 *
 * @since 0.1.0
 */
if ( \Jentil()->utilities()->page()->is( 'singular' ) ) {
	require_once ( \Jentil()->utilities()->filesystem()->templates_dir( 'path', '/singular.php' ) );
} else {
	require_once ( \Jentil()->utilities()->filesystem()->templates_dir( 'path', '/index.php' ) );
}

endif;
