<?php

/**
 * Single template layout customizer setting
 *
 * Add settings and controls for our Single template
 * layout options in the customizer.
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

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Single template layout customizer setting
 *
 * Add settings and controls for our Single template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Single extends Customizer\Setting {
    /**
     * Layout section
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Layout\Layout     $layout     Layout section instance
     */
    private $layout;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer\Layout\Layout $layout, $post_type ) {
        $this->layout = $layout;
        $this->name = sanitize_key( 'single_' . $post_type->name . '_layout' );
        $this->args = array(
            'default'       =>  $this->layout->get( 'default' ),
            //'transport'   =>  'postMessage',
        );

        $this->control = array(
            'section'   => $this->layout->get( 'name' ),
            'label'     => sprintf( esc_html__( 'Single %s', 'jentil' ), $post_type->labels->singular_name ),
            'type'      => 'select',
            'choices'   => $this->layout->get( 'customizer' )->get( 'template' )->get( 'layout' )->layouts_ids_names(),
        );
	}
}