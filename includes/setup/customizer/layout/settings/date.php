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

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

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
final class Date extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Layout\Layout $layout ) {
        $this->mod = Utilities\Mods\Mods::instance()->layout( 'date' );

        parent::__construct( $layout );

        $this->control['active_callback'] = function () {
            return Utilities\Template\Template::instance()->is( 'date' );
        };

        $this->control['label'] = esc_html__( 'Date Archives', 'jentil' );
	}
}