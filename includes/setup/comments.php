<?php

/**
 * Comments
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Comments
 *
 * @link            http://example.com
 * @since           Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/setup
 */
final class Comments extends MagPack\Utilities\Wizard {
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
    public function __construct( Jentil $jentil ) {
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
    public function js() {
    	if (
            ! Utilities\Template\Template::instance()->is( 'singular' )
            || ! comments_open()
            || ! get_option( 'thread_comments' )
        ) {
            return;
        }

        wp_enqueue_script( 'comment-reply' );
    }
}