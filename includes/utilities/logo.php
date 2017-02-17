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
     * @return      string      The logo markup limked to home
     */
    public function markup() {
        if ( function_exists( 'get_custom_logo' ) ) {
            return get_custom_logo();
        }
        
        $custom_logo_id = $this->mod();

        if ( $custom_logo_id ) {
            return sprintf( '<a href=\'%1$s\' class=\'custom-logo-link\' rel=\'home\' itemprop=\'url\'>%2$s</a>',
                home_url( '/' ),
                wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ) )
            );
        }
        
        if ( is_customize_preview() ) {
            return sprintf( '<a href=\'%1$s\' class=\'custom-logo-link jentil-logo-link\' style=\'display:none;\'><img class=\'custom-logo\' data-width=\'%2$s\' data-height=\'%3$s\' data-src=\'%4$s\' data-alt=\'%5$s\' itemprop=\'logo\' /></a>',
            home_url( '/' ), $this->width(), $this->height(), $this->URL(), '' );
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
     * Get logo URL
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      string              The logo URL
     */
    public function URL() {
        $source = $this->attributes();
        
        return ( isset( $source['url'] ) ? esc_url( $source['url'] ) : 0 );
    }
    
    /**
     * Get logo width
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      integer              The logo width
     */
    public function width() {
        $source = $this->attributes();
        
        return ( isset( $source['width'] ) ? absint( $source['width'] ) : '' );
    }
    
    /**
     * Get logo height
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      integer              The logo height
     */
    public function height() {
        $source = $this->attributes();
        
        return ( isset( $source['height'] ) ? absint( $source['height'] ) : '' );
    }
    
    /**
     * Get logo attributes
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array              The logo attributes
     */
    public function attributes() {
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
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array              The logo attributes
     */
    public function raw_attributes() {
        return ( array ) apply_filters( 'jentil_logo', array(
            'height' => 60,
            'width' => 180,
            'flex-width' => false,
            'flex-height' => false,
        ) );
    }
}