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
    die;
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
        $sections = [];

        $sections['author'] = new Author( $this );
        $sections['date'] = new Date( $this );
        $sections['search'] = new Search( $this );

        if ( ( $taxonomies = $this->customizer->get( 'taxonomies' ) ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $sections[ 'taxonomy_' . $taxonomy->name ] = new Taxonomy( $this, $taxonomy );
            }
        }

        if ( ( $post_types = $this->customizer->get( 'archive_post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                $sections[ 'sticky_' . $post_type->name ] = new Sticky( $this, $post_type );
                $sections[ 'post_type_' . $post_type->name ] = new Post_Type( $this, $post_type );
            }
        }

        return $sections;
    }
}