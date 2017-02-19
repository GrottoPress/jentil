<?php

/**
 * Posts customizer panel
 *
 * The sections, settings and controls for our posts
 * panel in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Posts customizer sections
 *
 * The sections, settings and controls for our posts
 * panel in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/setup
 * @since			Jentil 0.1.0
 */
final class Posts extends Setup\Customizer\Panel {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = 'posts';

        $this->args = array(
            'title' => esc_html__( 'Posts', 'jentil' ),
            // 'description' => esc_html__( 'Description here', 'jentil' ),
        );
	}

	/**
     * Get sections
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function sections() {
        $sections = array();

        $sections[] = new Sticky( $this );
        $sections[] = new Author( $this );
        $sections[] = new Date( $this );
        $sections[] = new Search( $this );

        if ( ( $taxonomies = $this->customizer->get( 'taxonomies' ) ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                if ( is_taxonomy_hierarchical( $taxonomy->name ) ) {
                    if ( version_compare( get_bloginfo( 'version' ), '4.5', '<' ) ) {
                        $terms = get_terms( $taxonomy->name, array(
                            'hide_empty' => 0,
                            // 'parent' => 0,
                        ) );
                    } else {
                        $terms = get_terms( array(
                            'taxonomy' => $taxonomy->name,
                            'hide_empty' => 0,
                            // 'parent' => 0,
                        ) );
                    }

                    if ( ! $terms || is_wp_error( $terms ) ) {
                        continue;
                    }

                    foreach ( $terms as $term ) {
                        $sections[] = new Taxonomy( $this, $taxonomy, $term );
                    }
                } else {
                    $sections[] = new Taxonomy( $this, $taxonomy );
                }
            }
        }

        if ( ( $post_types = $this->customizer->get( 'post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                if ( $post_type->has_archive ||  'post' == $post_type->name ) {
                    $sections[] = new Post_Type( $this, $post_type );
                }
            }
        }

        return $sections;
    }
}