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
    die;
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
        
        $this->args = [
            'title' => esc_html__( 'Layout', 'jentil' ),
            // 'description' => esc_html__( 'Description here', 'jentil' ),
        ];
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = [];

        $settings['author'] = new Settings\Author( $this );
        $settings['date'] = new Settings\Date( $this );
        $settings['error_404'] = new Settings\Error_404( $this );
        $settings['search'] = new Settings\Search( $this );

        if ( ( $taxonomies = $this->customizer->get( 'taxonomies' ) ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $settings[ 'taxonomy_' . $taxonomy->name ] = new Settings\Taxonomy( $this, $taxonomy );
            }
        }

        if ( ( $post_types = $this->customizer->get( 'archive_post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                $settings[ 'post_type_' . $post_type->name ] = new Settings\Post_Type( $this, $post_type );
            }
        }

        if ( ( $post_types = $this->customizer->get( 'post_types' ) ) ) {
            foreach ( $post_types as $post_type ) {
                if ( ! is_post_type_hierarchical( $post_type->name ) ) {
                    $settings[ 'single_' . $post_type->name ] = new Settings\Singular( $this, $post_type );
                }
            }
        }

        return $settings;
    }
}