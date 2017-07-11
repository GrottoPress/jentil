<?php

/**
 * Theme functions
 *
 * @see         https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Autoload
 * 
 * @since		Jentil 0.1.0
 */
require_once get_template_directory() . '/vendor/autoload.php';

/**
 * Begin execution of the theme.
 *
 * @action      after_setup_theme
 * 
 * @since       Jentil 0.1.0
 */
add_action( 'after_setup_theme', function () {
    if ( ! jentil_activator()->checks() ) {
        return;
    }

    jentil_setup()->run();
}, 0 );