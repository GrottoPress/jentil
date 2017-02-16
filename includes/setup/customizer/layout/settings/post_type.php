<?php

/**
 * Post type archive template layout customizer setting
 *
 * Add settings and controls for our Post type archive template
 * layout options in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Post type archive template layout customizer setting
 *
 * Add settings and controls for our Post type archive template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Post_Type extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Layout\Layout $layout, $post_type ) {
        $this->mod = new Utilities\Mods\Layout( 'post_type_archive', $post_type->name );

        parent::__construct( $layout );
        
        $this->control['active_callback'] = function () use ( $post_type ) {
            if ( 'post' == $post_type->name ) {
                return $this->layout->get( 'customizer' )->get( 'template' )->is( 'home' );
            }

            return $this->layout->get( 'customizer' )->get( 'template' )->is( 'post_type_archive', $post_type->name );
        };
	}
}