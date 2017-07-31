<?php

/**
 * Theme Mods
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
final class Mods {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard, MagPack\Utilities\Singleton;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct() {}

    /**
     * Colophon Mod
     * 
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      \GrottoPress\Jentil\Utilities\Mods\Colophon     Colophon mod
     */
    public function colophon() {
        return new Colophon( $this );
    }

    /**
     * Layout Mod
     * 
     * @var         string      $context        Template name
     * @var         string      $specific       Post type name or taxonomy name
     * @var         string      $more_specific  Post ID or term ID
     * 
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      \GrottoPress\Jentil\Utilities\Mods\Layout     Layout mod
     */
    public function layout( $context = '', $specific = '', $more_specific = '' ) {
        return new Layout( $this, $context, $specific, $more_specific );
    }

    /**
     * Logo Mod
     * 
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      \GrottoPress\Jentil\Utilities\Mods\Logo     Logo mod
     */
    public function logo() {
        return new Logo( $this );
    }

    /**
     * Posts Mod
     * 
     * @var         string      $context        Context
     * @var         string      $setting        Setting
     * 
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      \GrottoPress\Jentil\Utilities\Mods\Posts     Posts mod
     */
    public function posts( $setting, $args = [] ) {
        return new Posts( $this, $setting, $args );
    }

    /**
     * Title Mod
     * 
     * @var         string      $context        Template name
     * @var         string      $specific       Post type name or taxonomy name
     * @var         string      $more_specific  Post ID or term ID
     * 
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      \GrottoPress\Jentil\Utilities\Mods\Title     Title mod
     */
    public function title( $context = '', $specific = '', $more_specific = '' ) {
        return new Title( $this,  $context, $specific, $more_specific );
    }
}