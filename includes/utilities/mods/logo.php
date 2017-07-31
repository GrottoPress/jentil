<?php

/**
 * Logo mods
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Mods;

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Logo Mods
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Logo extends Mod {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Mods $mods ) {
        $this->name = 'custom_logo';
        $this->default = '';

        parent::__construct( $mods );
    }

    /**
     * Get mod
     *
     * @since		Jentil 0.1.0
     * @access      public
     *
     * @return      integer          Mod
     */
    public function mod() {
        return absint( get_theme_mod( $this->name, $this->default ) );
    }
}