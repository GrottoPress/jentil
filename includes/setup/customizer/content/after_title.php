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

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;

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
class After_Title extends Customizer\Setting {
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
        $this->name = sanitize_key( $this->content->name() . '_after_title' );
        $this->args = array(
            'default' => 'published_date, comments_link',
            //'transport' => 'postMessage',
        );

        $this->control = array(
            'section' => $this->content->name(),
            'label' => esc_html__( 'After title (comma-separated)', 'jentil' ),
            'type' => 'text',
        );
	}
}