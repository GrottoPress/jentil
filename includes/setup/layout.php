<?php

/**
 * Layout setup
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Layout setup
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */
final class Layout extends MagPack\Utilities\Wizard {
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
     * Body class
     *
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @filter      body_class
     */
    public function body_class( $classes ) {
        $template = Utilities\Template\Template::instance();

        $layout = $template->get( 'layout' );

        if ( ( $mod = $layout->mod() ) ) {
            $classes[] = sanitize_title( 'layout-' . $mod );
        }

        if ( ( $column = $layout->column() ) ) {
            $classes[] = sanitize_title( 'layout-' . $column );
        }

        return $classes;
    }
}