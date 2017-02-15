<?php

/**
 * Single template layout customizer setting
 *
 * Add settings and controls for our Single template
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

/**
 * Single template layout customizer setting
 *
 * Add settings and controls for our Single template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Single extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Layout\Layout $layout, $post_type ) {
        parent::__construct( $layout );

        $this->name = sanitize_key( 'single_' . $post_type->name . '_' . $this->layout->get( 'name' ) );
        
        $this->control['active_callback'] = function () use ( $post_type ) {
            if ( is_post_type_hierarchical( $post_type->name ) ) {
                return false;
            }

            return $this->layout->get( 'customizer' )->get( 'template' )->is( 'singular', $post_type->name );
        };
	}
}