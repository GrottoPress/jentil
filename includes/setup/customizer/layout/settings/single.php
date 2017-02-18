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
use GrottoPress\Jentil\Utilities;

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
	public function __construct( Setup\Customizer\Layout\Layout $layout, $post_type, $post = '' ) {
        if ( $post ) {
            $this->mod = new Utilities\Mods\Layout( 'singular', $post_type->name, $post->ID );
        } else {
            $this->mod = new Utilities\Mods\Layout( 'singular', $post_type->name );
        }

        parent::__construct( $layout );
        
        $this->control['active_callback'] = function () use ( $post_type, $post ) {
            $template = $this->layout->get( 'customizer' )->get( 'template' );

            if ( $post ) {
                return ( $template->is( 'page', $post->ID )
                    || $template->is( 'single', $post->ID )
                    || $template->is( 'attachment', $post->ID ) );
            }

            return $template->is( 'singular', $post_type->name );
        };

        if ( $post ) {
            $this->control['label'] = sprintf( esc_html__( '%1$s: %2$s', 'jentil' ), $post_type->labels->singular_name, $post->post_title );
        } else {
            $this->control['label'] = $post_type->labels->name;
        }
	}
}