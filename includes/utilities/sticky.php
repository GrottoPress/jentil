<?php

/**
 * Sticky Content
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Sticky Content
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Sticky extends MagPack\Utilities\Wizard {
    /**
     * Get setting
     * 
     * @var         string      $setting        Setting to retrieve
     * @var         mixed       $default        Default setting
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      mixed          Setting value
     */
    public function mod( $setting, $default = '' ) {
        if ( ! ( $name = $this->mod_name( $setting ) ) ) {
            return false;
        }

        return get_theme_mod( $name, $default );
    }

    /**
     * Get setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Setting name
     */
    private function mod_name( $setting ) {
        return sanitize_key( 'sticky_content_' . $setting );
    }
}