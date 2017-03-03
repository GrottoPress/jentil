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
final class Layout extends MagPack\Utilities\Singleton {
	/**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    protected function __construct() {}

    /**
     * Body class
     *
     * @since       MagPress MagPack 0.1.0
     * @access      public
     * 
     * @filter      body_class
     */
    public function body_class( $classes ) {
        $layout = ( new Utilities\Template\Template() )->get( 'layout' );

        if ( ( $mod = $layout->mod() ) ) {
            $classes[] = sanitize_title( 'layout-' . $mod );
        }

        if ( ( $column = $layout->column() ) ) {
            $classes[] = sanitize_title( 'layout-' . $column );
        }

        return $classes;
    }
}