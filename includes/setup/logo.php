<?php

/**
 * Logo
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Logo
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Logo extends MagPack\Utilities\Singleton {
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
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Add theme support for custom logo.
     * 
     * @see         https://codex.wordpress.org/Theme_Logo
     * 
     * @since       Jentil 0.1.0
     * @since       WordPress 4.5
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable() {
        add_theme_support( 'custom-logo', array(
           'height'      => 60,
           'width'       => 180,
        ) );
    }

    /**
     * Render logo
     *
     * @since       Jentil 0.1.0
	 * @access      public
	 *
	 * @action      jentil_inside_header
     */
    public function render() {
    	echo ( new Utilities\Logo() )->markup();
    }
}