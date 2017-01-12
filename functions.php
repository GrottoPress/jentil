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

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Check dependencies
 *
 * @var 		boolean 		$satisfied 		Whether or not dependencies are satisfied.
 *
 * @since 		Jentil 0.1.0
 */

$satisfied = true;

if ( ! class_exists( '\GrottoPress\MagPack\Setup\MagPack' ) ) {
	$satisfied = false;

	if ( ! is_admin() ) {
		wp_die( esc_html__( 'This theme requires MagPack plugin. Kindly install that first.' ) );
	}
}

/**
 * Autoload
 * 
 * @since		Jentil 0.1.0
 */
require get_template_directory() . '/vendor/autoload.php';

/**
 * Begins execution of the theme.
 * 
 * @action		after_setup_theme
 *
 * @since 		Jentil 0.1.0
 */
function run() {
	$jentil = Setup\Jentil::get_instance();
	$jentil->run();
}

/**
 * Run plugin
 * 
 * @since   	Jentil 0.1.0
 */
if ( $satisfied ) {
	add_action( 'after_setup_theme', '\GrottoPress\Jentil\run', 0 );
}