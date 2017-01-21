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

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;

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
class Taxonomy extends Content {
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
    public function __construct( Customizer\Customizer $customizer, $taxonomy ) {
        $this->taxonomy = $taxonomy;
        $this->name = sanitize_key( $this->taxonomy->name . '_taxonomy_content' );
        $post_type = $this->taxonomy->object_type[0];
        $this->args = array(
            'title' => sprintf(
                esc_html__( '%1$s %2$s Content', 'jentil' ),
                ( 'post' == $post_type ? '' : ucwords( $post_type ) ),
                str_ireplace( $post_type, '', $this->taxonomy->labels->singular_name )
            ),
            //'priority' => 200,
        );

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

        if ( 'post' == $this->taxonomy->object_type[0] ) {
            $settings[] = new Settings\Sticky_Posts( $this );
        }

        return array_merge( $settings, parent::settings() );
    }
}