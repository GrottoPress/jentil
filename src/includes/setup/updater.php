<?php

/**
 * Updater
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Updater
 *
 * @since 0.1.0
 */
final class Updater extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'check_for_update' ] );
    }

    /**
     * Check for update
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function check_for_update() {
        \Puc_v4_Factory::buildUpdateChecker( 'https://api.grottopress.com/wp-update-server/v1/?action=get_metadata&slug=jentil',
            $this->jentil->dir( 'path', '/functions.php' ), 'jentil' );
    }
}
