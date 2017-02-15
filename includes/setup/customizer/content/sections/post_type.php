<?php

/**
 * Post type archive content customizer section
 *
 * The sections, settings and controls for our
 * Post type archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes/setup
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content\Sections;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Post type archive content customizer section
 *
 * The sections, settings and controls for our
 * Post type archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes/setup
 * @since           Jentil 0.1.0
 */
final class Post_Type extends Content {
    /**
     * Post type
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \WP_Post_Type      $post_type       Post type object
     */
    protected $layouts;

    /**
     * Constructor
     *
     * @var         \WP_Post_Type      $post_type       Post type object
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Content\Content $content, $post_type ) {
        parent::__construct( $content );

        $this->post_type = $post_type;
        $this->name = sanitize_key( $this->post_type->name . '_post_type_' . $this->content->get( 'name' ) );

        $this->args = array(
            'title' => sprintf(
                esc_html__( '%s Archive Content', 'jentil' ),
                sanitize_text_field( $this->post_type->labels->singular_name )
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

        if ( 'post' == $this->post_type->name ) {
            $settings[] = new Setup\Customizer\Content\Settings\Sticky_Posts( $this );
        }

        return array_merge( $settings, parent::settings() );
    }
}