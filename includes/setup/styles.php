<?php

/**
 * Stylesheets
 *
 * Enqueue styles, and the like.
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
 * Stylesheets
 *
 * Enqueue styles, and the like.
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */
final class Styles extends MagPack\Utilities\Wizard {
	/**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }
    
    /**
     * Enqueue Styles
     * 
     * @since 		Jentil 0.1.0
     * @access 		public
     * 
     * @action      wp_enqueue_scripts
     */
    public function enqueue() {
    	$theme_dir_url = $this->jentil->get( 'dir_url' );

        wp_enqueue_style( 'normalize', $theme_dir_url . '/node_modules/normalize.css/normalize.css' );
        wp_enqueue_style( 'jentil', $theme_dir_url . '/assets/styles/jentil.css', array( 'normalize' ) );
        
        if ( is_rtl() ) {
            wp_enqueue_style( 'jentil-rtl', $theme_dir_url . '/assets/styles/rtl.css', array( 'jentil' ) );
        }
    }
}