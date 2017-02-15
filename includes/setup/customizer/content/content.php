<?php

/**
 * Content customizer panel
 *
 * The sections, settings and controls for our Content
 * panel in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Content customizer sections
 *
 * The sections, settings and controls for our Content
 * panel in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/setup
 * @since			Jentil 0.1.0
 */
final class Content extends Setup\Customizer\Panel {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Customizer $customizer ) {
        $this->name = 'content';

        $this->args = array(
            'title'     => esc_html__( 'Content', 'jentil' ),
            'description' => '', //esc_html__( 'Content description', 'jentil' ),
        );

        parent::__construct( $customizer );
	}

	/**
     * Get sections
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function sections() {
        $sections = array();

        $sections[] = new Sections\Sticky( $this );
        $sections[] = new Sections\Author( $this );
        $sections[] = new Sections\Date( $this );
        $sections[] = new Sections\Search( $this );

        if ( ( $taxonomies = $this->customizer->get( 'taxonomies' ) ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $sections[] = new Sections\Taxonomy( $this, $taxonomy );
            }
        }

        if ( ( $post_types = $this->customizer->get( 'post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                if (
                    $post_type->has_archive
                    || (
                        'post' == $post_type->name
                    )
                ) {
                    $sections[] = new Sections\Post_Type( $this, $post_type );
                }
            }
        }

        return $sections;
    }
}