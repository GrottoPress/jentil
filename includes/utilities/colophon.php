<?php

/**
 * Colophon
 *
 * Footer credits and related stuff
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
 * Colophon
 *
 * Footer credits and related stuff
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Colophon extends MagPack\Utilities\Wizard {
    /**
     * Get mod
     *
     * @since		Jentil 0.1.0
     * @access      public
     *
     * @return      string          The colophon mod
     */
    public function mod() {
        $colophon = get_theme_mod( $this->mod_name(), $this->mod_default() );

        $colophon = str_ireplace( '{{site_name}}', esc_attr( get_bloginfo( 'name' ) ), $colophon );
        $colophon = str_ireplace( '{{site_url}}', esc_attr( home_url( '/' ) ), $colophon );
        $colophon = str_ireplace( '{{this_year}}', esc_attr( date( 'Y' ) ), $colophon );
        $colophon = str_ireplace( '{{site_description}}', esc_attr( date( 'Y' ) ), $colophon );

        return wp_kses_data( $colophon );
    }

    /**
     * Mod name
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string          Mdo name
     */
    private function mod_name() {
        return 'colophon';
    }

    /**
     * Default mod
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string          Default mod
     */
    private function mod_default() {
        return sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'jentil' ),
            '<span itemprop="copyrightYear">{{this_year}}</span>',
            '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>' );
    }
}