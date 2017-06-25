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
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

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
	public function __construct( Setup\Customizer\Layout\Layout $layout, $taxonomy, $term = '' ) {
        $mod_context = 'tax';
        
        if ( 'post_tag' == $taxonomy->name ) {
            $mod_context = 'tag';
        } elseif ( 'category' == $taxonomy->name ) {
            $mod_context = 'category';
        }

        if ( $term ) {
            $this->mod = new Utilities\Mods\Layout( $mod_context, $taxonomy->name, $term->term_id );
        } else {
            $this->mod = new Utilities\Mods\Layout( $mod_context, $taxonomy->name );
        }

        parent::__construct( $layout );
        
        $this->control['active_callback'] = function () use ( $taxonomy, $term ) {
            $template = Utilities\Template\Template::instance();

            if ( $term ) {
                return ( $template->is( 'tag', $term->term_id )
                    || $template->is( 'category', $term->term_id )
                    || $template->is( 'tax', $taxonomy, $term->term_id ) );
            }

            if ( 'post_tag' == $taxonomy->name ) {
                return $template->is( 'tag' );
            }

            if ( 'category' == $taxonomy->name ) {
                return $template->is( 'category' );
            }

            return $template->is( 'tax', $taxonomy->name );
        };

        if ( $term ) {
            $this->control['label'] = sprintf( esc_html__( '%1$s Archive: %2$s', 'jentil' ),
                $taxonomy->labels->singular_name, $term->name );
        } else {
            $this->control['label'] = sprintf( esc_html__( '%1$s Archives', 'jentil' ),
                $taxonomy->labels->singular_name );
        }
	}
}