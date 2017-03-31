<?php

/**
 * Customizer section
 *
 * The template for all customizer section classes.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Setup;

/**
 * Colophon customizer section
 *
 * Add settings and controls for our colophon
 * section in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
abstract class Section extends MagPack\Utilities\Wizard {
    /**
     * Customizer
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Customizer     $customizer       Customizer instance
     */
    protected $customizer;

    /**
     * Section name
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string      $name       Name
     */
    protected $name;

    /**
     * Section arguments
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $args       Section arguments
     */
    protected $args;

    /**
     * Settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $settings       Settings
     */
    protected $settings;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 */
	protected function __construct( Setup\Customizer\Customizer $customizer ) {
        $this->customizer = $customizer;
	}

    /**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       MagPack 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return array( 'customizer', 'name', 'args', 'settings' );
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected abstract function settings();

    /**
     * Add section
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public final function add( $wp_customize ) {
        if ( $this->name ) {
            $wp_customize->add_section( $this->name, $this->args );
        }

        $this->settings = $this->settings();

        if ( $this->settings ) {
            foreach ( $this->settings as $setting ) {
                $setting->add( $wp_customize );
            }
        }
    }
}