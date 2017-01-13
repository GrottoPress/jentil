<?php

/**
 * Content title length setting
 *
 * Add setting and control for our content title length
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
 * Content title setting
 *
 * Add setting and control for our content title length
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Title_Words extends Customizer\Setting {
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
        $this->name = sanitize_key( $this->content->name() . '_title_words' );
        $this->args = array(
            'default' => -1,
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->name(),
            'label'     => esc_html__( 'Title length (number of words)', 'jentil' ),
            'type'      => 'number',
        );
	}
}