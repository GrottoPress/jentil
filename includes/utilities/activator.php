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
 * @subpackage      jentil/includes/utilities
 */

namespace GrottoPress\Jentil\Utilities;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Deactivator
 *
 * Checks and actions to perform during plugin
 * deactivation.
 * 
 * @author          N Atta Kusi Adusei
 */
final class Activator extends MagPack\Utilities\Singleton {
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
     * Are dependencies satisfied?
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @var         boolean         $satisfied      Whether or not all dependecies are met?
     */
    private $satisfied;

	/**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 */
	protected function __construct() {
	    $this->WP_version = get_bloginfo( 'version' );

        /**
         * Why we require this version
         *
         * - Use of singular.php template
         * - 
         */
	    $this->required_WP = '4.3';

        $this->satisfied = true;
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

        return $this->satisfied;
    }

    /**
     * Check if MagPack plugin installed
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function check_MagPack() {
        if ( class_exists( '\GrottoPress\MagPack\Setup\MagPack' ) ) {
            return;
        }

        $this->satisfied = false;

        if ( $this->plugin_exists( 'magpack/magpack.php' ) ) {
            $this->messages[] = esc_html__( 'Jentil theme needs MagPack plugin activated.', 'jentil' )
            . ( current_user_can( 'activate_plugins' )
                ? ' <a href="' . $this->plugin_activation_url( 'magpack/magpack.php' ) . '">'
                    . __( 'Activate MagPack', 'jentil' )
                . '</a>.' : '' );
        } else {
            $this->messages[] = esc_html__( 'Jentil theme requires MagPack plugin.', 'jentil' )
                . ( current_user_can( 'install_plugins' )
                    ? ' <a rel="external nofollow" href="https://api.grottopress.com/wp-update-server/v1/?action=download&slug=magpack" itemprop="url">'
                        . esc_html__( 'Install MagPack', 'jentil' )
                    . '</a>.' : '' );
        }
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

        $this->satisfied = false;

        if ( current_user_can( 'update_core' ) ) {
            $string = esc_html__( 'Jentil theme requires WordPress version %1$s or newer. Your current version is %2$s.', 'jentil' );
            $string .= ' <a href="' . network_admin_url( '/update-core.php' ) . '">' . esc_html__( 'Update WordPress', 'jentil' ) . '</a>.';
        } else {
            $string = esc_html__( 'Jentil theme requires WordPress version %1$s or newer.', 'jentil' );
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

    /**
     * Plugin activation link
     *
     * @var     string      $plugin         Plugin name (eg. "my-plugin/my-plugin.php")
     *
     * @see     https://www.theaveragedev.com/generating-a-wordpress-plugin-activation-link-url/
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string      Plugin activation URL
     */
    private function plugin_activation_url( $plugin ) {
        $plugin = sanitize_text_field( $plugin );

        $url = add_query_arg( array(
            'action' => 'activate',
            'plugin' => urlencode_deep( $plugin ),
        ), admin_url( 'plugins.php' ) );

        $url = wp_nonce_url( $url, "activate-plugin_{$plugin}" );

        return $url;
    }

    /**
     * Does plugin exist?
     *
     * @var     string      $plugin         Plugin name (eg. "my-plugin/my-plugin.php")
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function plugin_exists( $plugin ) {
        $plugin = sanitize_text_field( $plugin );

        return file_exists( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $plugin );
    }
}