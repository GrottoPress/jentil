<?php

/**
 * Error 404 template layout customizer setting
 *
 * Add settings and controls for our Error 404 template
 * layout options in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Layout;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Error 404 template layout customizer setting
 *
 * Add settings and controls for our Error 404 template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Error_404 extends Customizer\Setting {
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
	public function __construct( Customizer\Layout\Layout $layout ) {
        $this->layout = $layout;
        $this->name = 'error_404_layout';
        $this->args = array(
            'default'       =>  $this->layout->default(),
            //'transport'   =>  'postMessage',
        );

        $this->control = array(
            'section'   => $this->layout->name(),
            'label'     => esc_html__( 'Error 404', 'jentil' ),
            'type'      => 'select',
            'choices'   => $this->layout->customizer()->template()->layout()->layouts_ids_names(),
        );
	}
}