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
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

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
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Posts $posts ) {
        parent::__construct( $posts );

        $this->name = 'sticky_posts';

        $this->mod_args['context'] = 'sticky';

        $this->args['title'] = esc_html__( 'Sticky Posts', 'jentil' );
        // $this->args['panel'] = '';
        $this->args['active_callback'] = function () {
            $template = $this->posts->get( 'customizer' )->get( 'template' );

            if ( $template->is( 'home' ) ) {
                $post_type = 'post';
            } elseif ( $template->is( 'post_type_archive' ) ) {
                $post_type = get_query_var( 'post_type' );
            } else {
                return false;
            }

            if ( is_array( $post_type ) ) {
                $post_type = $post_type[0];
            }

            return $this->has_sticky( $post_type );
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