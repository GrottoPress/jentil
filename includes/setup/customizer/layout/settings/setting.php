<?php

/**
 * Layout customizer setting
 *
 * The template for all layout customizer setting classes.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Layout customizer setting
 *
 * The template for all layout customizer setting classes.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
abstract class Setting extends Setup\Customizer\Setting {
    /**
     * Layout section
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Layout\Layout     $layout     Layout section instance
     */
    protected $layout;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct( Setup\Customizer\Layout\Layout $layout ) {
        $this->layout = $layout;

        $this->args = array(
            'default'           => 'content-sidebar',
            'sanitize_callback' => 'sanitize_title',
        );

        $this->control = array(
            'section'   => $this->layout->get( 'name' ),
            'label'     => esc_html__( 'Select layout', 'jentil' ),
            'type'      => 'select',
            'choices'   => $this->layout->get( 'customizer' )->get( 'template' )->get( 'layout' )->layouts_ids_names(),
        );
    }
}