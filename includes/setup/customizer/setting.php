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
abstract class Setting {
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
     * Setting default
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string      $default       Default setting
     */
    //protected $default;

    /**
     * Get attributes
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function get( $attribute ) {
        $disallow = array( 'args', 'control' );

        if ( in_array( $attribute, $disallow ) ) {
            return null;
        }

        return $this->$attribute;
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