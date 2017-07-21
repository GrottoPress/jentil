<?php

/**
 * Colophon customizer setting
 *
 * Add settings and controls for our colophon
 * options in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Colophon\Settings;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Colophon customizer setting
 *
 * Add settings and controls for our colophon
 * options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Colophon extends Setup\Customizer\Setting {
    /**
     * Colophon section
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Colophon\Colophon     $colophon    Colophon
     */
    private $colophon;

    /**
     * Mod
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Utilities\Mod\Colophon     $mod    Colophon mod
     */
    private $mod;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Colophon\Colophon $colophon ) {
        $this->colophon = $colophon;

        $this->mod = new Utilities\Mods\Colophon();

        $this->name = $this->mod->get( 'name' );

        $this->args = [
            'default' => $this->mod->get( 'default' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'wp_kses_data',
        ];
        
        $this->control = [
            'section'   => $this->colophon->get( 'name' ),
            'label'     => esc_html__( 'Colophon', 'jentil' ),
            'type'      => 'text',
        ];
	}
}