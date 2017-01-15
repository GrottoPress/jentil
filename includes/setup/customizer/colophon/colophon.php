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

use GrottoPress\Jentil\Setup\Customizer;

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
class Colophon extends Customizer\Section {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer\Customizer $customizer ) {
        $this->name = 'colophon';
        $this->args = array(
            'title'     => esc_html__( 'Colophon', 'jentil' ),
            //'priority'  => 200,
        );

        parent::__construct( $customizer );
	}

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings[] = new Settings\Colophon( $this );

        return $settings;
    }
}