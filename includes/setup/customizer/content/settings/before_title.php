<?php

/**
 * Content 'before title' setting
 *
 * Add setting and control for our content 'before title'
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
 * Content 'before title' setting
 *
 * Add setting and control for our content 'before title'
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Before_Title extends Setup\Customizer\Setting {
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

        $this->name = $this->content->get( 'name' ) . '_before_title';
        
        $this->args = array(
            'default' => ( $this->content->get( 'default' ) )['before_title'],
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->get( 'name' ),
            'label'     => esc_html__( 'Before title (comma-separated)', 'jentil' ),
            'type'      => 'text',
        );
	}
}