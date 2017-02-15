<?php

/**
 * Taxonomy template layout customizer setting
 *
 * Add settings and controls for our Taxonomy template
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
 * Taxonomy template layout customizer setting
 *
 * Add settings and controls for our Taxonomy template
 * layout options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Taxonomy extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Layout\Layout $layout, $taxonomy ) {
        parent::__construct( $layout );

        $this->name = sanitize_key( $taxonomy->name . '_taxonomy_' . $this->layout->get( 'name' ) );
        
        $this->control['active_callback'] = function () use ( $taxonomy ) {
            if ( 'post_tag' == $taxonomy->name ) {
                return $this->layout->get( 'customizer' )->get( 'template' )->is( 'tag' );
            } elseif ( 'category' == $taxonomy->name ) {
                return $this->layout->get( 'customizer' )->get( 'template' )->is( 'category' );
            }

            return $this->layout->get( 'customizer' )->get( 'template' )->is( 'tax', $taxonomy->name );
        };
	}
}