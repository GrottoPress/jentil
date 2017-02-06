<?php

/**
 * Content 'after title' setting
 *
 * Add setting and control for our content 'after title'
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
 * Content 'after title' setting
 *
 * Add setting and control for our content 'after title'
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class After_Title extends Setup\Customizer\Setting {
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

        $this->name = $this->content->get( 'name' ) . '_after_title';
        
        $this->args = array(
            'default' => ( $this->content->get( 'default' ) )['after_title'],
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->get( 'name' ),
            'label' => esc_html__( 'After title (comma-separated)', 'jentil' ),
            'type' => 'text',
        );
	}
}