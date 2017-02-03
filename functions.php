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

global $pagenow;

/**
 * Check dependencies
 *
 * @var 		boolean 		$satisfied 		Whether or not dependencies are satisfied.
 *
 * @since 		Jentil 0.1.0
 */

$messages = array();

if ( ! function_exists( '\GrottoPress\MagPack\run' ) ) {
	$messages[] = __( 'This theme requires <a href="#" itemprop="url">MagPack</a> plugin. Kindly install and activate that first.', 'jentil' );
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
	$jentil = Setup\Jentil::instance();
	$jentil->run();
}

/**
 * Run plugin
 * 
 * @since   	Jentil 0.1.0
 */
if ( $messages ) {
	if ( is_admin() ) {
		foreach ( $messages as $message ) {
			add_action( 'admin_notices', function () use ( $message ) {
				echo '<div class="notice notice-error"><p>' . $message . '</p></div>';
			} );
		}
	} elseif ( $pagenow !== 'wp-login.php' && $pagenow !== 'wp-signup.php' ) {
		wp_die( $messages[0] );
	}
} else {
	add_action( 'after_setup_theme', '\GrottoPress\Jentil\run', 0 );
}