<?php

/**
 * Author template layout customizer setting
 *
 * Add settings and controls for our author template
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
 * Author template layout customizer setting
 *
 * Add settings and controls for our author template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Author extends Customizer\Setting {
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
        $this->name = 'author_archive_layout';
        $this->args = array(
            'default'       =>  $this->layout->default(),
            //'transport'   =>  'postMessage',
        );

        $this->control = array(
            'section'   => $this->layout->name(),
            'label'     => esc_html__( 'Author archive', 'jentil' ),
            'type'      => 'select',
            'choices'   => $this->layout->template()->layout()->layouts_ids_names(),
        );
	}
}