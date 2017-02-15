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

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

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
final class Post_Type extends Section {
    /**
     * Post type
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \WP_Post_Type      $post_type       Post type object
     */
    protected $post_type;

    /**
     * Constructor
     *
     * @var         \WP_Post_Type      $post_type       Post type object
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Customizer $customizer, $post_type ) {
        parent::__construct( $customizer );

        $this->post_type = $post_type;

        $this->name = sanitize_key( $this->post_type->name . '_post_type_posts' );

        $this->args['active_callback'] = function () {
            if ( 'post' == $this->post_type->name ) {
                return $this->customizer->get( 'template' )->is( 'home' );
            }

            return $this->customizer->get( 'template' )->is( 'post_type_archive', $this->post_type->name );
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

        if ( 'post' == $this->post_type->name ) {
            $settings[] = new Settings\Sticky_Posts( $this );
        }

        return array_merge( $settings, parent::settings() );
    }
}