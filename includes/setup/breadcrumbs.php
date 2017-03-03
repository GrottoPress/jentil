<?php

/**
 * Breadcrumbs
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
 * Breadcrumbs
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Breadcrumbs extends MagPack\Utilities\Singleton {
    /**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {}

    /**
     * Render
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_before_title
     */
    public function render() {
        $template = new Utilities\Template\Template();
        $pagination = new MagPack\Utilities\Pagination\Pagination();

        if ( $template->is( 'front_page' ) && ! $pagination->is_paged() ) {
            return;
        }

        $args = array(
            'before' => esc_html__( 'Path: ', 'jentil' ),
        );

        echo $template->breadcrumbs( $args )->trail();
    }
}