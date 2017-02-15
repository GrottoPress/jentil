<?php

/**
 * Search template layout customizer setting
 *
 * Add settings and controls for our Search template
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

use GrottoPress\Jentil\Setup;

/**
 * Search template layout customizer setting
 *
 * Add settings and controls for our Search template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Search extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Layout\Layout $layout ) {
        parent::__construct( $layout );

        $this->name = 'search_' . $this->layout->get( 'name' );
        
        $this->control['active_callback'] = function () {
            return $this->layout->get( 'customizer' )->get( 'template' )->is( 'search' );
        };
	}
}