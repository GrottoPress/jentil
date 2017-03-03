<?php

/**
 * Posts
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
 * Posts
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Posts extends MagPack\Utilities\Singleton {
    /**
     * Template
     *
     * @since       MagPack 0.1.0
     * @access      protected
     *
     * @var    \GrottoPress\Jentil\Utilities\Template\Template      $template       Template
     */
    protected $template;

    /**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {
        $this->template = new Utilities\Template\Template();
    }

    /**
     * Add <body> classes
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @filter      body_class
     */
    public function body_class( $classes ) {
        if ( ! $this->template->is( 'singular' ) ) {
            return $classes;
        }

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

        return $classes;
    }

    /**
     * Post parent link
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_before_title
     */
    public function parent_link() {
        if ( ! $this->template->is( 'singular' ) ) {
            return;
        }

        global $post;

        if ( ! $post->post_parent ) {
            return;
        }

        echo '<h4 class="parent entry-title">
            <a href="' . get_permalink( $post->post_parent ) . '">
                <span class="meta-nav">&laquo;</span> ' . get_the_title( $post->post_parent )
            . '</a>
        </h4>';
    }

    /**
     * Attachment
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_before_content
     */
    public function attachment() {
        if ( ! $this->template->is( 'attachment' ) ) {
            return;
        }

        remove_filter( 'the_content', 'prepend_attachment' );

        global $post;

        if ( wp_attachment_is_image( $post->ID ) ) {
            get_template_part( 'parts/attachment', 'image' );
        } elseif ( wp_attachment_is( 'audio', $post->ID ) ) {
            get_template_part( 'parts/attachment', 'audio' );
        } elseif ( wp_attachment_is( 'video', $post->ID ) ) {
            get_template_part( 'parts/attachment', 'video' );
        } else {
            get_template_part( 'parts/attachment' );
        }
    }

    /**
     * Single post after title
     *
     * Used for single posts when using the index.php template.
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @filter      jentil_singular_after_title
     */
    public function single_post_after_title_( $output, $id, $separator ) {
        if ( ! $this->template->is( 'singular', 'post' ) ) {
            return $output;
        }

        $magpack_post = new MagPack\Utilities\Post\Post( $id );
        $avatar = $magpack_post->info( 'avatar__40', '' )->list();
        $author = $magpack_post->info( 'author_link', '' )->list();

        if ( ! empty( $avatar ) ) {
            $output .= $avatar;
        }

        if ( ! empty( $author ) ) {
            $output .= '<p>' . $author . '</p>';
        }

        $output .= '<p>' . $magpack_post->info( 'published_date, published_time, comments_link' )->list() . '</p>

        <div class="self-clear"></div>';

        return $output;
    }

    /**
     * Single post after title
     *
     * Replicates the functionality above for when
     * using the single.php template
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_after_title
     */
    public function single_post_after_title() {
        if ( ! $this->template->is( 'singular', 'post' ) ) {
            return;
        }

        global $post;

        $magpack_post = new MagPack\Utilities\Post\Post( $post->ID );
        $avatar = $magpack_post->info( 'avatar__40', '' )->list();
        $author = $magpack_post->info( 'author_link', '' )->list();

        $output = '<div class="entry-meta after-title self-clear">';

        if ( ! empty( $avatar ) ) {
            $output .= $avatar;
        }

        if ( ! empty( $author ) ) {
            $output .= '<p>' . $author . '</p>';
        }

        $output .= '<p>'
            . $magpack_post->info( 'published_date, published_time, comments_link' )->list()
        . '</p>

        </div>';

        echo $output;
    }
}