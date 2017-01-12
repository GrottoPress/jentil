<?php

/**
 * Template Layout customizer section
 *
 * Add section, settings and controls for our colophon
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Layout;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;
use GrottoPress\Jentil\Utilities\Template\Template;

/**
 * Template Layout customizer section
 *
 * Add section, settings and controls for our colophon
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           jentil 0.1.0
 */
class Layout extends Customizer\Section {
    /**
     * Taxonomies
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $taxonomies       Taxonomies
     */
    protected $taxonomies;

    /**
     * Post types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $post_types       Post types
     */
    protected $post_types;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Customizer\Customizer $customizer ) {
        $this->name = 'layout';
        $this->args = array(
            'title'     => esc_html__( 'Layout', 'jentil' ),
            //'priority'  => 200,
        );
        $this->taxonomies = get_taxonomies( array(
            'public' => true,
            'show_ui' => true,
        ), 'objects' );
        $this->post_types = get_post_types( array(
            'public' => true,
            'show_ui' => true,
        ), 'objects' );

        parent::__construct( $customizer );
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings[] = new Author( $this );
        $settings[] = new Date( $this );
        $settings[] = new Error_404( $this );
        $settings[] = new Search( $this );

        if ( $this->taxonomies ) {
            foreach ( $this->taxonomies as $taxonmy ) {
                $settings[] = new Taxonomy( $this, $taxonmy );
            }
        }

        if ( $this->post_types ) {
            foreach ( $this->post_types as $post_type ) {
                if ( $post_type->has_archive || ! is_post_type_hierarchical( $post_type->name ) ) {
                    $settings[] = new Post_Type( $this, $post_type );
                }
            }

            foreach ( $this->post_types as $post_type ) {
                if ( ! is_post_type_hierarchical( $post_type->name ) ) {
                    $settings[] = new Single( $this, $post_type );
                }
            }
        }

        return $settings;
    }

    /**
     * Get template instance
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function template() {
        return new Template();
    }

    /**
     * Get default layout
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function default() {
        return 'content-sidebar';
    }
}