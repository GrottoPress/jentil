<?php

/**
 * Body class
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Body class
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Body_Class extends MagPack\Utilities\Singleton {
    /**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {}

    /**
     * Add <body> classes
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @filter      body_class
     */
    public function add( $classes ) {
        $template = new Utilities\Template\Template();

        if ( $template->is( 'singular' ) ) {
            global $post;

            if ( is_post_type_hierarchical( $post->post_type ) ) {
                if ( ! empty( $post->post_parent ) ) {
                    $parent_id = $post->post_parent;

                    while ( $parent_id ) {
                        $page = get_post( $parent_id );
                        $classes[] = sanitize_title( $post->post_type . '-parent-' . $page->ID );
                        $parent_id = $page->post_parent;
                    }
                }
            }

            $page_template = get_page_template_slug( $post->ID );

            if ( $page_template ) {
                $classes[] = sanitize_title( $page_template );
            }

            if ( post_type_supports( $post->post_type, 'comments' ) ) {
                $classes[] = get_option( 'show_avatars' ) ? 'show-avatars' : 'hide-avatars';
                $classes[] = get_option( 'thread_comments' ) ? 'threaded-comments' : 'unthreaded-comments';
                $classes[] = comments_open( $post->ID ) ? 'comments-open' : 'comments-closed';
            }

            if ( has_shortcode( $post->post_content, 'magpack_posts' ) ) {
                $classes[] = 'has-magpack-posts'; // Move to MagPack?
            }
        }

        return $classes;
    }
}