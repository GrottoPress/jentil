<?php

/**
 * Sticky Posts Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use \WP_Post_Type;

/**
 * Sticky Posts Section
 *
 * @since 0.1.0
 */
final class Sticky extends Section {
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Setup\Customizer\Posts\Posts $posts Posts.
     * @param \WP_Post_Type $post_type Post type.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Posts $posts, WP_Post_Type $post_type ) {
        parent::__construct( $posts );

        $this->name = \sanitize_key( $post_type->name . '_sticky_posts' );

        $this->mod_args['context'] = 'sticky';
        $this->mod_args['specific'] = $post_type->name;

        // $this->args['panel'] = '';
        $this->args['title'] = \sprintf( \esc_html__( 'Sticky %s', 'jentil' ),
            $post_type->labels->name );
        $this->args['active_callback'] = function () use ( $post_type ): bool {
            $page = $this->posts->customizer()->jentil()->utilities()->page();
            $has_sticky = $this->has_sticky( $post_type->name );

            if ( 'post' == $post_type->name ) {
                return ( $page->is( 'home' ) && $has_sticky );
            } elseif ( \post_type_exists( $post_type->name ) ) {
                return ( $page->is( 'post_type_archive' ) && $has_sticky );
            }

            return false;
        };
    }

    /**
     * Does post type have sticky posts?
     *
     * @since 0.1.0
     * @access private
     *
     * @return bool
     */
    private function has_sticky( string $post_type ): bool {
        $sticky_posts = \get_option( 'sticky_posts' );

        if ( $sticky_posts ) {
            foreach ( $sticky_posts as $post ) {
                if ( \get_post_type( $post ) == $post_type ) {
                    return true;
                }
            }
        }

        return false;
    }
}
