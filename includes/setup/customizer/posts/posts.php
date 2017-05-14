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

        $sections[] = new Author( $this );
        $sections[] = new Date( $this );
        $sections[] = new Search( $this );

        if ( ( $taxonomies = $this->customizer->get( 'taxonomies' ) ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $sections[] = new Taxonomy( $this, $taxonomy );
            }
        }

        if ( ( $post_types = $this->customizer->get( 'archive_post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                $sections[] = new Sticky( $this, $post_type );
                $sections[] = new Post_Type( $this, $post_type );
            }
        }

        return $sections;
    }
}