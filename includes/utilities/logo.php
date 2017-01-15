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
class Logo {
    /**
     * Get logo
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      string      The logo markup limked to home
     */
    public function get_markup() {
        if ( function_exists( 'get_custom_logo' ) ) {
            return get_custom_logo();
        }
        
        $custom_logo_id = $this->get_mod();

        if ( $custom_logo_id ) {
            return sprintf( '<a href=\'%1$s\' class=\'custom-logo-link\' rel=\'home\' itemprop=\'url\'>%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ) )
            );
        }
        
        if ( is_customize_preview() ) {
            return sprintf( '<a href=\'%1$s\' class=\'custom-logo-link jentil-logo-link\' style=\'display:none;\'><img class=\'custom-logo\' data-width=\'%2$s\' data-height=\'%3$s\' data-src=\'%4$s\' data-alt=\'%5$s\' itemprop=\'logo\' /></a>',
            esc_url( home_url( '/' ) ), esc_attr( $this->width() ), esc_attr( $this->height() ), esc_attr( $this->URL() ), esc_attr( '' ) );
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
    public function get_mod( $default = '' ) {
        return absint( get_theme_mod( 'custom_logo', $default ) );
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
        
        return isset( $source['url'] ) ? $source['url'] : '';
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
        
        return isset( $source['width'] ) ? $source['width'] : '';
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
        
        return isset( $source['height'] ) ? $source['height'] : '';
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
        return wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
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
        return wp_get_attachment_metadata( get_theme_mod( 'custom_logo' ), $unfiltered );
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
        return apply_filters( 'jentil_logo', array(
            'height' => 60,
            'width' => 180,
            'flex-height' => false,
            'flex-height' => false,
        ) );
    }
}