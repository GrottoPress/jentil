<?php

/**
 * Author template title customizer setting
 *
 * Add setting and control for our author template
 * title options in the customizer.
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
 * Author template title customizer setting
 *
 * Add setting and control for our author template
 * title options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Author extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Title\Title $title ) {
        $this->mod = new Utilities\Mods\Title( 'author' );

        parent::__construct( $title );

        $this->control['active_callback'] = function () {
            return Utilities\Template\Template::instance()->is( 'author' );
        };

        $this->control['label'] = esc_html__( 'Author Archives', 'jentil' );
	}
}