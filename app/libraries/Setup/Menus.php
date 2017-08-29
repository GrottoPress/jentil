<?php

/**
 * Menus
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
 * Menus
 *
 * @since 0.1.0
 */
final class Menus extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'register' ] );
        \add_action( 'jentil_inside_header', [ $this, 'render_header_menu' ] );
        \add_action( 'jentil_inside_header', [ $this, 'render_header_menu_toggle' ] );
        \add_action( 'jentil_inside_header', [ $this, 'render_mobile_header_menu' ] );
        \add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_js' ] );
    }

    /**
     * Menus
     * 
     * Register navigation menus
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action after_setup_theme
     */
    public function register() {
        \register_nav_menus( [
            'primary-menu' => \esc_html__( 'Primary menu', 'jentil' ),
        ] );
    }

    /**
     * Header menu
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render_header_menu() {
        echo '<nav class="site-navigation screen-min-wide p">'
            . $this->skip_to( 'content', \esc_html__( 'Skip to content', 'jentil' ) );

            \wp_nav_menu( [ 'theme_location' => 'primary-menu' ] );
        echo '</nav>';
    }

    /**
     * Header menu button
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render_header_menu_toggle() {
        $status = isset( $_GET['menu'] ) ? \sanitize_key( $_GET['menu'] ) : 'off';
        
        echo '<div class="menu-toggle screen-max-wide p">'
            . $this->skip_to( 'menu-screen-max-wide', \esc_html__( 'Skip to menu', 'jentil' ) )

            . '<a class="js-mobile-menu-button hamburger" href="' . \esc_url( \add_query_arg( [
                    'menu' => ( $status == 'off' ? 'on' : 'off' ),
                ], $this->jentil->utilities()->page()->url( true ) ) ) . '" rel="nofollow"><span class="fa fa fa-bars" aria-hidden="true"></span> <span class="menu-button-text icon-text">' . \esc_html__( 'Menu', 'jentil' ) . '</span></a>
        </div>';
    }

    /**
     * Mobile header menu
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render_mobile_header_menu() {
        $status = isset( $_GET['menu'] ) ? \sanitize_key( $_GET['menu'] ) : 'off';
        
        echo '<nav id="menu-screen-max-wide" class="js-mobile-menu site-navigation screen-max-wide p"' . ( $status == 'off' ? ' style="display:none;"' : '' ) . '>'
            . $this->skip_to( 'content', \esc_html__( 'Skip to content', 'jentil' ) );

            \get_search_form(); \wp_nav_menu( [ 'theme_location' => 'primary-menu' ] );
        echo '</nav>';
    }

    /**
     * Enqueue JS
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action wp_enqueue_scripts
     */
    public function enqueue_js() {
        \wp_enqueue_script( 'jentil-menu', $this->jentil->utilities()->filesystem()->scripts_dir( 'url', '/menu.min.js' ),
            [ 'jquery' ], '', true );
    }

    /**
     * Skip to some location
     *
     * For screen readers
     *
     * @var string $location ID of element to skip to.
     * @var string $title Anchor link text
     *
     * @since 0.1.0
     * @access private
     *
     * @action jentil_inside_header
     */
    private function skip_to( string $location, string $title = '' ): string {
        return '<a class="screen-reader-text skip-link" href="#'
            . \sanitize_title( $location ) . '">' . \sanitize_text_field( $title ) . '</a>';
    }
}