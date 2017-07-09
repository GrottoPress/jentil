<?php

/**
 * Functions
 *
 * Sets up the theme.
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

namespace GrottoPress\Jentil;

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Autoload
 *
 * Include composer autoloader
 * 
 * @since		Jentil 0.1.0
 */
require_once get_template_directory() . '/vendor/autoload.php';

/**
 * Run plugin
 * 
 * @action		after_setup_theme
 *
 * @since 		Jentil 0.1.0
 */
function run() {
	if ( ! Utilities\Activator::instance()->checks() ) {
		return;
	}

	$jentil = Setup\Jentil::instance();
	$jentil->run();
}

/**
 * Begin execution of the theme.
 * 
 * @since       Jentil 0.1.0
 */
add_action( 'after_setup_theme', '\GrottoPress\Jentil\run', 0 );