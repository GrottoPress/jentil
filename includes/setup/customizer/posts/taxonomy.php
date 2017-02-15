<?php

/**
 * Taxonomy archive content customizer section
 *
 * The sections, settings and controls for our
 * Taxonomy archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Taxonomy archive content customizer section
 *
 * The sections, settings and controls for our
 * Taxonomy archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Taxonomy extends Section {
    /**
     * Taxonomy
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     object      $taxonomy       Taxonomy object
     */
    protected $taxonomy;

    /**
     * Constructor
     *
     * @var         object      $taxonomy       Taxonomy object
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Customizer $customizer, $taxonomy ) {
        parent::__construct( $customizer );

        $this->taxonomy = $taxonomy;

        $this->name = sanitize_key( $this->taxonomy->name . '_taxonomy_posts' );

        $this->args['active_callback'] = function () {
            if ( 'post_tag' == $this->taxonomy->name ) {
                return $this->customizer->get( 'template' )->is( 'tag' );
            } elseif ( 'category' == $this->taxonomy->name ) {
                return $this->customizer->get( 'template' )->is( 'category' );
            }

            return $this->customizer->get( 'template' )->is( 'tax', $this->taxonomy->name );
        };
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        if ( 'post' == $this->taxonomy->object_type[0] ) {
            $settings[] = new Settings\Sticky_Posts( $this );
        }

        return array_merge( $settings, parent::settings() );
    }
}