<?php

/**
 * Content excerpt setting
 *
 * Add setting and control for our content excerpt
 * setting in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Content excerpt setting
 *
 * Add setting and control for our content excerpt
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Excerpt extends Customizer\Setting {
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
	public function __construct( Customizer\Content\Content $content ) {
        $this->content = $content;
        $this->name = sanitize_key( $this->content->name() . '_excerpt' );
        $this->args = array(
            'default' => '300',
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->name(),
            'label' => esc_html__( 'Excerpt', 'jentil' ),
            'type' => 'text',
        );
	}
}