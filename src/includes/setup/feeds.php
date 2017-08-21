<?php

/**
 * Feeds (Atom, RSS etc.)
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
 * Feeds (Atom, RSS etc.)
 *
 * @since 0.1.0
 */
final class Feeds extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'add_support' ] );
    }

    /**
     * Add support for RSS and atom feeds
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action after_setup_theme
     */
    public function add_support() {
        \add_theme_support( 'automatic-feed-links' );
    }
}
