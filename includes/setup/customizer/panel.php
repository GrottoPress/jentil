<?php

/**
 * Customizer panel
 *
 * The template for all customizer panel classes.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Setup;

/**
 * Colophon customizer section
 *
 * Add sections, settings and controls for our content
 * panel in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
abstract class Panel extends MagPack\Utilities\Wizard {
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
     * Sections
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $sections       Sections
     */
    protected $sections;
    
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
        return array( 'customizer', 'name', 'args', 'sections' );
    }

    /**
     * Get sections
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected abstract function sections();

    /**
     * Add panel
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public final function add( $wp_customize ) {
        if ( $this->name ) {
            $wp_customize->add_panel( $this->name, $this->args );
        }

        $this->sections = $this->sections();

        if ( $this->sections ) {
            foreach ( $this->sections as $section ) {
                $section->add( $wp_customize );
            }
        }
    }
}