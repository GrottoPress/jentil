<?php

/**
 * Updates Checker
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Updates Checker
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Updater extends MagPack\Utilities\Singleton {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	protected function __construct() {}

    /**
     * Check for update
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      after_setup_theme
     */
    public function check() {
        \Puc_v4_Factory::buildUpdateChecker( 'https://api.grottopress.com/wp-update-server/v1/?action=get_metadata&slug=jentil',
            get_template_directory() . '/functions.php', 'jentil' );
    }
}