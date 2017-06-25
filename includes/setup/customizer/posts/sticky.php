<?php

/**
 * Sticky content customizer section
 *
 * The sections, settings and controls for our sticky content
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Sticky content customizer section
 *
 * The sections, settings and controls for our sticky content
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Sticky extends Section {
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
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Posts $posts, $post_type ) {
        parent::__construct( $posts );

        $this->post_type = $post_type;

        $this->name = sanitize_key( $this->post_type->name . '_sticky_posts' );

        $this->mod_args['context'] = 'sticky';
        $this->mod_args['specific'] = $this->post_type->name;

        $this->args['title'] = sprintf( esc_html__( 'Sticky %s', 'jentil' ),
            $this->post_type->labels->name );
        // $this->args['panel'] = '';
        $this->args['active_callback'] = function () {
            $template = Utilities\Template\Template::instance();
            $has_sticky = $this->has_sticky( $this->post_type->name );

            if ( 'post' == $this->post_type->name ) {
                return ( $template->is( 'home' ) && $has_sticky );
            } elseif ( post_type_exists( $this->post_type->name ) ) {
                return ( $template->is( 'post_type_archive' ) && $has_sticky );
            }

            return false;
        };
    }

    /**
     * Does post type have sticky posts?
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function has_sticky( $post_type = '' ) {
        if ( ! $post_type || ! post_type_exists( $post_type ) ) {
            return false;
        }

        $sticky_posts = get_option( 'sticky_posts' );

        $has_sticky = array_map( function ( $value ) use ( $post_type ) {
            return ( get_post_type( $value ) == $post_type );
        }, $sticky_posts );

        return in_array( true, $has_sticky );
    }
}