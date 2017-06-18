<?php

/**
 * JavaScript
 *
 * Enqueue javascript, and the like.
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * JavaScript
 *
 * Enqueue javascript, and the like.
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */
final class JavaScript extends MagPack\Utilities\Singleton {
	/**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    protected function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }
    
    /**
     * Enqueue JS
     * 
     * @since 		Jentil 0.1.0
     * @access 		public
     * 
     * @action      wp_enqueue_scripts
     */
    public function enqueue() {
    	global $jentil_template;

        if ( $jentil_template->is( 'singular' ) && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}