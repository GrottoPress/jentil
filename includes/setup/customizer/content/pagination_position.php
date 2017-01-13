<?php

/**
 * Content pagination setting
 *
 * Add setting and control for our content pagination
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
 * Content pagination setting
 *
 * Add setting and control for our content pagination
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Pagination_Position extends Customizer\Setting {
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
        $this->name = sanitize_key( $this->content->name() . '_pagination_position' );
        $this->args = array(
            'default' => 'bottom',
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->name(),
            'label' => esc_html__( 'After content', 'jentil' ),
            'type' => 'select',
            'choices' => $this->content->pagination_positions(),
        );
	}
}