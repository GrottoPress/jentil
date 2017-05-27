<?php

/**
 * Author template layout customizer setting
 *
 * Add setting and control for our author template
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
use GrottoPress\Jentil\Utilities;

/**
 * Author template layout customizer setting
 *
 * Add setting and control for our author template
 * layout options in the customizer.
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
	public function __construct( Setup\Customizer\Layout\Layout $layout ) {
        $this->mod = new Utilities\Mods\Layout( 'author' );

        parent::__construct( $layout );

        $this->control['active_callback'] = function () {
            return $this->layout->get( 'customizer' )->get( 'template' )->is( 'author' );
        };

        $this->control['label'] = esc_html__( 'Author Archives', 'jentil' );
	}
}