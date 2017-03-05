<?php

/**
 * Menus
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
 * Menus
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Menus extends MagPack\Utilities\Singleton {
    /**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {}

    /**
     * Menus
     * 
     * Register navigation menus
     * 
     * @since       jentil 0.1.0
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function register() {
        register_nav_menus( array(
            'primary-menu' => esc_html__( 'Primary menu', 'jentil' ),
        ) );
    }

    /**
     * Header menu
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_inside_header
     */
    public function header_menu() {
        echo '<nav role="navigation" class="site-navigation screen-min-wide margin-vertical">'
            . $this->skip_to( 'content', esc_html__( 'Skip to content', 'jentil' ) );

            wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );
        echo '</nav>';
    }

    /**
     * Mobile header menu button
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_inside_header
     */
    public function mobile_header_menu_toggle() {
        $pagination = new MagPack\Utilities\Pagination\Pagination();
        $status = isset( $_GET['menu'] ) ? sanitize_key( $_GET['menu'] ) : 'off';
        
        echo '<div class="menu-toggle screen-max-wide margin-vertical">'
            . $this->skip_to( 'menu-screen-max-wide', esc_html__( 'Skip to menu', 'jentil' ) )

            . '<div class="menu-mobile-menu-container">
                <ul class="menu">
                    <li class="menu-item hamburger">
                        <a href="' . esc_url( add_query_arg( array(
                            'menu' => ( $status == 'off' ? 'on' : 'off' ),
                        ), $pagination->page_url( true, true ) ) ) . '"><span class="fa fa fa-bars" aria-hidden="true"></span> <span class="menu-button-text icon-text">' . esc_html__( 'Menu', 'jentil' ) . '</span></a>
                    </li>
                </ul>
            </div>
        </div>';
    }

    /**
     * Mobile header menu
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_after_header
     */
    public function mobile_header_menu() {
        $status = isset( $_GET['menu'] ) ? sanitize_key( $_GET['menu'] ) : 'off';
        
        echo '<nav role="navigation" class="site-navigation screen-max-wide margin-vertical"' . ( $status == 'off' ? ' style="display:none;"' : '' ) . '>'
            . $this->skip_to( 'content', esc_html__( 'Skip to content', 'jentil' ) );

            get_search_form(); wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );
        echo '</nav>';
    }

    /**
     * Skip to some location
     *
     * For screen readers
     *
     * @var         string      $location       ID of element to skip to.
     * @var         string      $title          Anchor link text
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @action      jentil_after_header
     */
    private function skip_to( $location, $title = '' ) {
        return '<div class="screen-reader-text skip-link">
            <a href="#' . sanitize_title( $location ) . '">' . sanitize_text_field( $title ) . '</a>
        </div>';
    }
}