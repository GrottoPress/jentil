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
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
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
final class Logo extends MagPack\Utilities\Wizard {
    /**
     * Get logo
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
                wp_get_attachment_image( $mod, 'full', false, array(
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ) )
            );
        }
        
        if ( is_customize_preview() ) {
            return '<a href="' . home_url( '/' ) . '" class="custom-logo-link js-logo-link" style="display:none;"><img class="custom-logo" itemprop="logo" /></a>';
        }
    }

    /**
     * Get colophon
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      string          The colophon text
     */
    public function mod() {
        return ( new Mods\Logo() )->mod();
    }
    
    /**
     * Get logo src
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array              The logo src
     */
    public function src() {
        return wp_get_attachment_image_src( $this->mod(), 'full' );
    }
    
    /**
     * Get logo meta
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array              The logo attributes
     */
    public function meta( $unfiltered = false ) {
        return wp_get_attachment_metadata( $this->mod(), $unfiltered );
    }
    
    /**
     * Logo attributes
     *
     * We need this for when theme support for
     * custom_logo not available
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array              The logo attributes
     */
    public function attributes() {
        return ( array ) apply_filters( 'jentil_logo', array(
            'height' => 60,
            'width' => 180,
            'flex-width' => false,
            'flex-height' => false,
        ) );
    }
}