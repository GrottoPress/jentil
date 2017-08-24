<?php

/**
 * Comments
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
 * Comments
 *
 * @since 0.1.0
 */
final class Comments extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_js' ] );
    }
    
    /**
     * Enqueue JS
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action wp_enqueue_scripts
     */
    public function enqueue_js() {
        if (
            ! $this->jentil->utilities()->page()->is( 'singular' )
            || ! \comments_open()
            || ! \get_option( 'thread_comments' )
        ) {
            return;
        }

        \wp_enqueue_script( 'comment-reply' );
    }
}
