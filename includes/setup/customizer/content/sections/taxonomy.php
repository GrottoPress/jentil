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

namespace GrottoPress\Jentil\Setup\Customizer\Content\Sections;

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
final class Taxonomy extends Content {
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
    public function __construct( Setup\Customizer\Content\Content $content, $taxonomy ) {
        parent::__construct( $content );

        $this->taxonomy = $taxonomy;
        $this->name = sanitize_key( $this->taxonomy->name . '_taxonomy_' . $this->content->get( 'name' ) );

        $post_type = sanitize_key( $this->taxonomy->object_type[0] );
        
        $this->args = array(
            'title' => sprintf(
                esc_html__( '%1$s %2$s Content', 'jentil' ),
                ucwords( str_ireplace( 'post' , '', $post_type ) ),
                sanitize_text_field( str_ireplace( $post_type, '', $this->taxonomy->labels->singular_name ) )
            ),
            'panel' => $this->content->get( 'name' ),
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

        if ( 'post' == $this->taxonomy->object_type[0] ) {
            $settings[] = new Setup\Customizer\Content\Settings\Sticky_Posts( $this );
        }

        return array_merge( $settings, parent::settings() );
    }
}