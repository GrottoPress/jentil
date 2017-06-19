<?php

/**
 * Colophon customizer section
 *
 * Add section, settings and controls for our colophon
 * section in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Colophon;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Colophon customizer section
 *
 * Add section, settings and controls for our colophon
 * section in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Colophon extends Setup\Customizer\Section {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = 'colophon';
        
        $this->args = array(
            'title'     => esc_html__( 'Colophon', 'jentil' ),
        );
	}

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings['colophon'] = new Settings\Colophon( $this );

        return $settings;
    }
}