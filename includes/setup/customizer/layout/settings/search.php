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
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

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
        $this->mod = Utilities\Mods\Mods::instance()->layout( 'search' );

        parent::__construct( $layout );
        
        $this->control['active_callback'] = function () {
            return Utilities\Template\Template::instance()->is( 'search' );
        };

        $this->control['label'] = esc_html__( 'Search Results', 'jentil' );
	}
}