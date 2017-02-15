<?php

/**
 * Sticky posts toggle setting
 *
 * Add setting and control for our sticky posts
 * toggle in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Sticky posts toggle setting
 *
 * Add setting and control for our sticky posts
 * toggle in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Sticky_Posts extends Setup\Customizer\Setting {
    /**
     * Content section
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Content\Content     $content     Content section instance
     */
    private $content;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $content ) {
        $this->content = $content;

        $this->name = $this->content->get( 'name' ) . '_sticky_posts';
        
        $this->args = array(
            'default' => ( $this->content->get( 'default' ) )['sticky_posts'],
            //'transport' => 'postMessage',
            'sanitize_callback' => 'absint',
        );

        $this->control = array(
            'section' => $this->content->get( 'name' ),
            'label' => esc_html__( 'Show sticky posts?', 'jentil' ),
            'type' => 'checkbox',
        );
	}
}