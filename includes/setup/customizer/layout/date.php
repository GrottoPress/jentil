<?php

/**
 * Date template layout customizer setting
 *
 * Add setting and control for our Date template
 * layout setting in the customizer.
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
 * Date template layout customizer setting
 *
 * Add setting and control for our Date template
 * layout setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Date extends Customizer\Setting {
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
        $this->name = 'date_archive_layout';
        $this->args = array(
            'default'       =>  $this->layout->default(),
            //'transport'   =>  'postMessage',
        );

        $this->control = array(
            'section'   => $this->layout->name(),
            'label'     => esc_html__( 'Date archive', 'jentil' ),
            'type'      => 'select',
            'choices'   => $this->layout->customizer()->template()->layout()->layouts_ids_names(),
        );
	}
}