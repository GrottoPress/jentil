<?php

/**
 * Theme Mod
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

use GrottoPress\MagPack;

/**
 * Theme Mod
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
abstract class Mod extends MagPack\Utilities\Wizard {
    /**
     * Name
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         string     $name     Mod name
     */
    protected $name;

    /**
     * Default
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         mixed     $default     Default value
     */
    protected $default;

    /**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       Jentil 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return array( 'name', 'default' );
    }

    /**
     * Get mod
     *
     * @since		Jentil 0.1.0
     * @access      public
     *
     * @return      string          The colophon mod
     */
    public abstract function mod();
}