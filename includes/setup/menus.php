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
final class Menus extends MagPack\Utilities\Wizard {
    /**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

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
        echo '<nav class="site-navigation screen-min-wide p">'
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
        $pagination = new MagPack\Utilities\Pagination();
        $status = isset( $_GET['menu'] ) ? sanitize_key( $_GET['menu'] ) : 'off';
        
        echo '<div class="menu-toggle screen-max-wide p">'
            . $this->skip_to( 'menu-screen-max-wide', esc_html__( 'Skip to menu', 'jentil' ) )

            . '<a class="js-mobile-menu-button hamburger" href="' . esc_url( add_query_arg( array(
                    'menu' => ( $status == 'off' ? 'on' : 'off' ),
                ), $pagination->page_url( true, true ) ) ) . '" rel="nofollow"><span class="fa fa fa-bars" aria-hidden="true"></span> <span class="menu-button-text icon-text">' . esc_html__( 'Menu', 'jentil' ) . '</span></a>
        </div>';
    }

    /**
     * Mobile header menu
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_inside_header
     */
    public function mobile_header_menu() {
        $status = isset( $_GET['menu'] ) ? sanitize_key( $_GET['menu'] ) : 'off';
        
        echo '<nav id="menu-screen-max-wide" class="js-mobile-menu site-navigation screen-max-wide p"' . ( $status == 'off' ? ' style="display:none;"' : '' ) . '>'
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
     * @action      jentil_inside_header
     */
    private function skip_to( $location, $title = '' ) {
        return '<a class="screen-reader-text skip-link" href="#' . sanitize_title( $location ) . '">' . sanitize_text_field( $title ) . '</a>';
    }

    /**
     * Enqueue JS
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      wp_enqueue_scripts
     */
    public function js() {
        wp_enqueue_script( 'jentil-menu',
            $this->jentil->get( 'dir_url' ) . '/assets/javascript/menu.min.js',
            array( 'jquery' ),
            '',
            true );
    }
}