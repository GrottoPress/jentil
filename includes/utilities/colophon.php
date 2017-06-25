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
    die;
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
        return ( new Mods\Colophon() )->mod();
    }
}