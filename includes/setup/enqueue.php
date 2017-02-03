<?php

/**
 * Enqueue scripts and styles
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Enqueue scripts and styles
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */
final class Enqueue extends MagPack\Utilities\Singleton {
	/**
     * Enqueue JavaScript
     * 
     * @since 		Jentil 0.1.0
     * @access 		public
     * 
     * @action      wp_enqueue_scripts
     */
    public function scripts() {
    	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
        
        wp_enqueue_script( 'jentil-menu', get_template_directory_uri() . '/assets/javascript/menu.js', array( 'jquery' ), '', true );
    }
    
    /**
     * Styles
     * 
     * Add stylesheets.
     * 
     * @since 		Jentil 0.1.0
     * @access 		public
     * 
     * @action      wp_enqueue_scripts
     */
    public function styles() {
    	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/resources/normalize-css/normalize.css' );
        wp_enqueue_style( 'jentil', get_template_directory_uri() . '/assets/styles/jentil.css', array( 'normalize' ) );
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/vendor/fortawesome/font-awesome/css/font-awesome.min.css', array( 'normalize' ) );
        
        if ( is_rtl() ) {
            wp_enqueue_style( 'jentil-rtl', get_template_directory_uri() . '/assets/styles/rtl.css', array( 'jentil' ) );
        }
    }
}