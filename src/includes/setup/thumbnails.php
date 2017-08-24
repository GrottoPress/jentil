<?php

/**
 * Thumbnails (Featured Images)
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
 * Thumbnails (Featured Images)
 *
 * @since 0.1.0
 */
final class Thumbnails extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'add_support' ] );
        \add_action( 'after_setup_theme', [ $this, 'add_sizes' ] );
    }

    /**
     * Add support
     * 
     * Add support for featured images (post thumbnails).
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action after_setup_theme
     */
    public function add_support() {
        \add_theme_support( 'post-thumbnails' );
    }
    
    /**
     * Add/set thumbnail sizes.
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action after_setup_theme
     */
    public function add_sizes() {
        \set_post_thumbnail_size( 640, 360, true );
        
        \add_image_size( 'mini-thumb', 100, 100, true );
        \add_image_size( 'micro-thumb', 75, 75, true );
        \add_image_size( 'nano-thumb', 50, 50, true );
    }
}