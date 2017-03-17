<?php

/**
 * Activator
 *
 * Checks and actions to perform during theme
 * activation.
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Deactivator
 *
 * Checks and actions to perform during plugin
 * deactivation.
 * 
 * @author          N Atta Kusi Adusei
 */
final class Activator {
	/**
     * Current WordPress version
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         string         $WP_version       Current WordPress version
	 */
	private $WP_version;

	/**
     * Required WordPress version
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         string         $required_WP       Required minimum WordPress version
	 */
	private $required_WP;

    /**
     * Error messages
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var         array         $messages       Error messages
     */
    private $messages;

	/**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct() {
	    $this->WP_version = get_bloginfo( 'version' );

        /**
         * Why we require this version
         *
         * - Use of singular.php template
         * - 
         */
	    $this->required_WP = '4.3';

        $this->messages = array();
	}

	/**
     * Do activation checks
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      boolean         Whether or not the checks passed
     */
    public function checks() {
        $this->check_MagPack();
        $this->check_wp_version();

        $this->print_messages();

        return ( ! $this->messages );
    }

    /**
     * Check if MagPack plugin installed
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function check_MagPack() {
        if ( function_exists( '\GrottoPress\MagPack\run' ) ) {
            return;
        }

        $this->messages[] = __( 'This theme requires <a href="#" itemprop="url">MagPack</a> plugin. Install and activate that first.', 'jentil' );
    }

    /**
     * Do WordPress version check
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function check_wp_version() {
        if ( version_compare( $this->WP_version, $this->required_WP, '>=' ) ) {
        	return;
        }

        if ( current_user_can( 'update_core' ) ) {
            $string = esc_html__( 'This theme requires WordPress version %1$s or newer. Your current version is %2$s.', 'jentil' );
            $string .= ' <a href="' . network_admin_url( '/update-core.php' ) . '">' . esc_html__( 'Update WordPress', 'jentil' ) . '</a>.';
        } else {
            $string = esc_html__( 'This theme requires WordPress version %1$s or newer.', 'jentil' );
        }

        $this->messages[] = sprintf( $string, $this->required_WP, $this->WP_version );
    }

    /**
     * Output error message
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function print_messages() {
        if ( ! $this->messages ) {
            return;
        }

        global $pagenow;

        foreach ( $this->messages as $message ) {
            if ( is_admin() ) {
                add_action( 'admin_notices', function () use ( $message ) {
                    echo '<div class="notice notice-error"><p>' . $message . '</p></div>';
                } );
            } elseif ( $pagenow !== 'wp-login.php' && $pagenow !== 'wp-signup.php' ) {
                wp_die( $message );
            }
        }
    }
}