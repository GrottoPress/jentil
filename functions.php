<?php

/**
 * Functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

namespace GrottoPress\Jentil;

/**
 * Autoload
 * 
 * @since		Jentil 0.1.0
 */
require get_template_directory() . '/vendor/autoload.php';

/**
 * Begins execution of the theme.
 *
 * @since 		Jentil 0.1.0
 */
function run() {
	$jentil = new Jentil();
	$jentil->run();
}
add_action( 'after_setup_theme', '\GrottoPress\Jentil\run', 0 );