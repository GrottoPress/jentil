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
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Autoload
 * 
 * @since		Jentil 0.1.0
 */
require_once get_template_directory() . '/vendor/autoload.php';

/**
 * Begins execution of the theme.
 * 
 * @action		after_setup_theme
 *
 * @since 		Jentil 0.1.0
 */
function run() {
	if ( ! ( new Setup\Activator() )->checks() ) {
		return;
	}

	$jentil = Setup\Jentil::instance();
	$jentil->run();
}

/**
 * Run plugin
 * 
 * @since   	Jentil 0.1.0
 */
add_action( 'after_setup_theme', '\GrottoPress\Jentil\run', 0 );