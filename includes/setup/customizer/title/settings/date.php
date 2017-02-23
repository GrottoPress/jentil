<?php

/**
 * Date template title customizer setting
 *
 * Add setting and control for our Date template
 * title setting in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Date template title customizer setting
 *
 * Add setting and control for our Date template
 * title setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Date extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Title\Title $title ) {
        $this->mod = new Utilities\Mods\Title( 'date' );

        parent::__construct( $title );

        $this->control['active_callback'] = function () {
            return $this->title->get( 'customizer' )->get( 'template' )->is( 'date' );
        };

        $this->control['label'] = esc_html__( 'Date', 'jentil' );
	}
}