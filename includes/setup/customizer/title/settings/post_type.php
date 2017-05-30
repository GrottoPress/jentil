<?php

/**
 * Post type archive template title customizer setting
 *
 * Add settings and controls for our Post type archive template
 * title options in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Post type archive template title customizer setting
 *
 * Add settings and controls for our Post type archive template
 * title options in the customizer.
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
	public function __construct( Setup\Customizer\Title\Title $title, $post_type ) {
        $mod_context = ( 'post' == $post_type->name ? 'home' : 'post_type_archive' );

        $this->mod = new Utilities\Mods\Title( $mod_context, $post_type->name );

        parent::__construct( $title );
        
        $this->control['active_callback'] = function () use ( $post_type ) {
            $template = $this->title->get( 'customizer' )->get( 'template' );

            if ( 'post' == $post_type->name ) {
                return $template->is( 'home' );
            }

            return $template->is( 'post_type_archive', $post_type->name );
        };

        $this->control['label'] = sprintf( esc_html__( '%s Archive', 'jentil' ), $post_type->labels->name );
	}
}