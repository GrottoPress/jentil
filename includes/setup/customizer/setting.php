<?php

/**
 * Customizer setting
 *
 * The template for all customizer setting classes.
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

/**
 * Customizer setting
 *
 * The template for all setting classes.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
abstract class Setting extends MagPack\Utilities\Wizard {
   /**
     * Setting name
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string      $name       Setting name
     */
    protected $name;

    /**
     * Setting arguments
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $args       Setting arguments
     */
    protected $args = array();

    /**
     * Setting control
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $control       Setting control
     */
    protected $control = array();

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
        return array( 'args', 'control', 'name' );
    }

    /**
     * Add setting
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add( $wp_customize ) {
        if ( ! $this->name ) {
            return;
        }

        $wp_customize->add_setting( $this->name, $this->args );
        $wp_customize->add_control( $this->name, $this->control );
    }
}