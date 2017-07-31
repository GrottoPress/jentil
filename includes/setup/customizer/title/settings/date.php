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
    die;
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
        $this->mod = Utilities\Mods\Mods::instance()->title( 'date' );

        parent::__construct( $title );

        $this->control['active_callback'] = function () {
            return Utilities\Template\Template::instance()->is( 'date' );
        };

        $this->control['label'] = esc_html__( 'Date Archives', 'jentil' );
	}
}