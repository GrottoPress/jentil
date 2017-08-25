<?php

/**
 * Posts
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Posts
 *
 * @since 0.1.0
 */
final class Posts extends Setup {
   /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_filter( 'body_class', [ $this, 'add_body_classes' ] );
        // \add_action( 'jentil_before_before_title', [ $this, 'post_parent_link' ] );
        \add_action( 'jentil_before_content', [ $this, 'attachment' ] );
        // \add_filter( 'jentil_singular_after_title', [ $this, 'single_post_after_title_' ], 10, 3 );
        \add_action( 'jentil_after_title', [ $this, 'single_post_after_title' ] );
    }

    /**
     * Add <body> classes
     *
     * @since 0.1.0
     * @access public
     *
     * @filter body_class
     */
    public function add_body_classes( array $classes ): array {
        if ( ! $this->jentil->utilities()->page()->is( 'singular' ) ) {
            return $classes;
        }

        global $post;

        if ( \is_post_type_hierarchical( $post->post_type ) ) {
            if ( $post->post_parent ) {
                $parent_id = $post->post_parent;

                while ( $parent_id ) {
                    $page = \get_post( $parent_id );
                    $classes[] = \sanitize_title( $post->post_type . '-parent-' . $page->ID );
                    $parent_id = $page->post_parent;
                }
            }
        }

        $page_template = \get_page_template_slug( $post->ID );

        if ( $page_template ) {
            $classes[] = \sanitize_title( $page_template );
        }

        if ( \post_type_supports( $post->post_type, 'comments' ) ) {
            $classes[] = \get_option( 'show_avatars' ) ? 'show-avatars' : 'hide-avatars';
            $classes[] = \get_option( 'thread_comments' ) ? 'threaded-comments' : 'unthreaded-comments';
            $classes[] = \comments_open( $post->ID ) ? 'comments-open' : 'comments-closed';
        }

        return $classes;
    }

    /**
     * Post parent link
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_before_title
     */
    public function parent_link() {
        if ( ! $this->jentil->utilities()->page()->is( 'singular' ) ) {
            return;
        }

        global $post;

        if ( ! $post->post_parent ) {
            return;
        }

        echo '<h4 class="parent entry-title">
            <a href="' . \get_permalink( $post->post_parent ) . '">
                <span class="meta-nav">&laquo;</span> ' . \get_the_title( $post->post_parent )
            . '</a>
        </h4>';
    }

    /**
     * Attachment
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_content
     */
    public function attachment() {
        if ( ! $this->jentil->utilities()->page()->is( 'attachment' ) ) {
            return;
        }

        \remove_filter( 'the_content', 'prepend_attachment' );

        global $post;

        if ( \wp_attachment_is_image( $post->ID ) ) {
            \get_template_part( 'src/includes/partials/attachment', 'image' );
        } elseif ( \wp_attachment_is( 'audio', $post->ID ) ) {
            \get_template_part( 'src/includes/partials/attachment', 'audio' );
        } elseif ( \wp_attachment_is( 'video', $post->ID ) ) {
            \get_template_part( 'src/includes/partials/attachment', 'video' );
        } else {
            \get_template_part( 'src/includes/partials/attachment' );
        }
    }

    /**
     * Single post after title
     *
     * Used for single posts when using the index.php template.
     *
     * @since 0.1.0
     * @access public
     *
     * @filter jentil_singular_after_title
     */
    public function single_post_after_title_( string $output, int $id, string $separator ): string {
        if ( ! $this->jentil->utilities()->page()->is( 'singular', 'post' ) ) {
            return $output;
        }
        
        $jentil_post = $this->jentil->utilities()->post( $id );

        if ( ( $avatar = $jentil_post->info( 'avatar__40', '' )->list() ) ) {
            $output .= $avatar;
        }

        if ( ( $author = $jentil_post->info( 'author_link', '' )->list() ) ) {
            $output .= '<p>' . $author . '</p>';
        }

        $output .= '<p>' . $jentil_post->info( 'published_date, published_time, comments_link' )->list() . '</p>

        <div class="self-clear"></div>';

        return $output;
    }

    /**
     * Single post after title
     *
     * Replicates the functionality above for when
     * using the singular.php template
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_after_title
     */
    public function single_post_after_title() {
        if ( ! $this->jentil->utilities()->page()->is( 'singular', 'post' ) ) {
            return '';
        }

        global $post;

        $jentil_post = $this->jentil->utilities()->post( $post->ID );

        $output = '<aside class="entry-meta after-title self-clear">';

        if ( ( $avatar = $jentil_post->info( 'avatar__40', '' )->list() ) ) {
            $output .= $avatar;
        }

        if ( ( $author = $jentil_post->info( 'author_link', '' )->list() ) ) {
            $output .= '<p>' . $author . '</p>';
        }

        $output .= '<p>'
            . $jentil_post->info( 'published_date, published_time, comments_link' )->list()
        . '</p>

        </aside>';

        echo $output;
    }
}
