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

use GrottoPress\Jentil\Setup;

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
final class Layout extends Setup\Customizer\Section {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = 'layout';
        
        $this->args = array(
            'title' => esc_html__( 'Layout', 'jentil' ),
            // 'description' => esc_html__( 'Description here', 'jentil' ),
        );
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings[] = new Settings\Author( $this );
        $settings[] = new Settings\Date( $this );
        $settings[] = new Settings\Error_404( $this );
        $settings[] = new Settings\Search( $this );

        if ( ( $taxonomies = $this->customizer->get( 'taxonomies' ) ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $settings[] = new Settings\Taxonomy( $this, $taxonomy );
            }
        }

        if ( ( $post_types = $this->customizer->get( 'post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                if ( $post_type->has_archive || 'post' == $post_type->name ) {
                    $settings[] = new Settings\Post_Type( $this, $post_type );
                }
            }

            foreach ( $post_types as $post_type ) {
                if ( ! is_post_type_hierarchical( $post_type->name ) ) {
                    $settings[] = new Settings\Singular( $this, $post_type );
                }
            }
        }

        return $settings;
    }
}