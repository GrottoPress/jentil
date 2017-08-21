<?php

/**
 * Functions
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @see https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'JENTIL_REQUIRED_WP', '4.3' );
define( 'JENTIL_REQUIRED_PHP', '7.0' );

if ( version_compare( JENTIL_REQUIRED_PHP, phpversion(), '<=' )
    && version_compare( JENTIL_REQUIRED_WP, get_bloginfo( 'version' ), '<=' ) ) :

/**
 * Autoloader
 * 
 * @since 0.1.0
 */
require_once \get_template_directory() . '/vendor/autoload.php';

/**
 * Run this theme.
 *
 * @action after_setup_theme
 * 
 * @since 0.1.0
 */
\add_action( 'after_setup_theme', function () {
    \Jentil()->run();
}, 0 );

endif;
