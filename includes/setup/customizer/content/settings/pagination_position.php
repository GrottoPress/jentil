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

namespace GrottoPress\Jentil\Setup\Customizer\Content\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

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
final class Pagination_Position extends Setup\Customizer\Setting {
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

        $this->name = $this->content->get( 'name' ) . '_pagination_position';
        
        $this->args = array(
            'default' => ( $this->content->get( 'default' ) )['pagination_position'],
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->get( 'name' ),
            'label' => esc_html__( 'Pagination position', 'jentil' ),
            'type' => 'select',
            'choices' => $this->content->get( 'pagination_positions' ),
        );
	}
}