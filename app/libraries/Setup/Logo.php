<?php

/**
 * Logo
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
 * Logo
 *
 * @since 0.1.0
 */
final class Logo extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'add_support' ] );
        \add_action( 'jentil_inside_header', [ $this, 'render' ] );
    }

    /**
     * Add theme support for custom logo.
     * 
     * @see https://codex.wordpress.org/Theme_Logo
     * 
     * @since 0.1.0
     * @since WordPress 4.5
     *
     * @access public
     * 
     * @action after_setup_theme
     */
    public function add_support() {
        \add_theme_support( 'custom-logo', $this->jentil->utilities()->logo()->size() );
    }

    /**
     * Render logo
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render() {
        if ( \function_exists( 'get_custom_logo' ) ) {
            echo \get_custom_logo();
        } elseif ( ( $mod = $this->jentil->utilities()->logo()->mod() ) ) {
            echo \sprintf( '<a href=\'%1$s\' class=\'custom-logo-link\' rel=\'home\' itemprop=\'url\'>%2$s</a>',
                \home_url( '/' ),
                \wp_get_attachment_image( $mod, 'full', false, [
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ] )
            );
        } elseif ( \is_customize_preview() ) {
            echo '<a href="' . \home_url( '/' ) . '" class="custom-logo-link js-logo-link" style="display:none;"><img class="custom-logo" itemprop="logo" /></a>';
        }
    }
}
