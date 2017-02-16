<?php

/**
 * Colophon mods
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Mods;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Colophon Mods
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Colophon extends Mod {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct() {
        $this->name = 'colophon';
        $this->default = sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'jentil' ), '<span itemprop="copyrightYear">{{this_year}}</span>', '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>' );
    }

    /**
     * Get mod
     *
     * @since		Jentil 0.1.0
     * @access      public
     *
     * @return      string          Mod
     */
    public function mod() {
        $colophon = get_theme_mod( $this->name, $this->default );

        $colophon = str_ireplace( '{{site_name}}', esc_attr( get_bloginfo( 'name' ) ), $colophon );
        $colophon = str_ireplace( '{{site_url}}', esc_attr( home_url( '/' ) ), $colophon );
        $colophon = str_ireplace( '{{this_year}}', esc_attr( date( 'Y' ) ), $colophon );
        $colophon = str_ireplace( '{{site_description}}', esc_attr( date( 'Y' ) ), $colophon );

        return wp_kses_data( $colophon );
    }
}