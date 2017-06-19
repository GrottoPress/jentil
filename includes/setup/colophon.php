<?php

/**
 * Colophon
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
use GrottoPress\Jentil\Utilities;

/**
 * Colophon
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Colophon extends MagPack\Utilities\Wizard {
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
     * Render
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_inside_footer
     */
    public function render() {
        global $jentil_template;

        $colophon = new Utilities\Colophon();

        if ( ! ( $mod = $colophon->mod() ) && ! $jentil_template->is( 'customize_preview' ) ) {
            return '';
        }

        echo '<div id="colophon"><small>' . $mod . '</small></div><!-- #colophon -->';
    }
}