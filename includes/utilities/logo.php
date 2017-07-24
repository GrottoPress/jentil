<?php

/**
 * Logo
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Logo
 * 
 * @see             https://developer.wordpress.org/reference/functions/get_custom_logo/
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Logo {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard, MagPack\Utilities\Singleton;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct() {}

    /**
     * Get logo HTML
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      string      The logo markup linked to home
     */
    public function HTML() {
        if ( function_exists( 'get_custom_logo' ) ) {
            return get_custom_logo();
        }

        if ( ( $mod = $this->mod() ) ) {
            return sprintf( '<a href=\'%1$s\' class=\'custom-logo-link\' rel=\'home\' itemprop=\'url\'>%2$s</a>',
                home_url( '/' ),
                wp_get_attachment_image( $mod, 'full', false, [
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ] )
            );
        }
        
        if ( is_customize_preview() ) {
            return '<a href="' . home_url( '/' ) . '" class="custom-logo-link js-logo-link" style="display:none;"><img class="custom-logo" itemprop="logo" /></a>';
        }
    }

    /**
     * Get logo mod
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      string          The logo mod
     */
    public function mod() {
        return ( new Mods\Logo() )->mod();
    }

    /**
     * Logo size
     *
     * We need this for when theme support for
     * custom_logo not available
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array              The logo attributes
     */
    public function size() {
        return ( array ) apply_filters( 'jentil_logo', [
            'height' => 60,
            'width' => 180,
            'flex-width' => false,
            'flex-height' => false,
        ] );
    }
}