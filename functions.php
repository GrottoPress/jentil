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

if ( ! is_plugin_active( 'magpack/magpack.php' ) ) {
	$satisfied = false;

	$message = __( 'This theme requires <a href="#" itemprop="url">MagPack</a> plugin. Kindly install and activate that first.', 'jentil' );

	if ( is_admin() ) {
		add_action( 'admin_notices', function () use ( $message ) {
			echo '<div class="notice notice-error"><p>' . $message . '</p></div>';
		} );
	} else {
		wp_die( $message );
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