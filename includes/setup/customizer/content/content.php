<?php

/**
 * Content customizer sections
 *
 * The sections, settings and controls for our Content
 * sections in the customizer.
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

use GrottoPress\Jentil\Setup\Customizer\Customizer;
use GrottoPress\Jentil\Utilities\Template\Template;

/**
 * Content customizer sections
 *
 * The sections, settings and controls for our Content
 * sections in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Content {
    /**
     * Customizer
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Customizer     $customizer       Customizer instance
     */
    private $customizer;

    /**
     * Template
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Utilities\Template\Template     $customizer       Customizer instance
     */
    private $template;

    /**
     * Contents
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array           $contents       An array of content customizer objects
	 */
    private $contents;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer $customizer ) {
        $this->customizer = $customizer;
        $this->contents = $this->contents();
        $this->template = new Template();
	}

	/**
	 * Get template
	 *
	 * @since 		Jentil 0.1.0
	 * @access 		public
	 */
	public function template() {
		return $this->template;
	}
	
	/**
	 * Contents
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function contents() {
	    $contents = array();
	    
	    $contents[] = new Archive( $this );
	    $contents[] = new Search( $this );
	    $contents[] = new Sticky( $this );
	    
	    return $contents;
	}
    
    /**
	 * Add sections
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function add_sections( $wp_customize ) {
	    if ( empty( $this->contents ) ) {
	        return;
	    }
	    
	    foreach ( $this->contents as $content ) {
	        $content->add_section( $wp_customize );
	    }
	}
    
    /**
	 * Add settings
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function add_settings( $wp_customize ) {
	    if ( empty( $this->contents ) ) {
	        return;
	    }
	    
	    foreach ( $this->contents as $content ) {
	        $content->add_settings( $wp_customize );
	    }
	}
	
	/**
	 * Add controls
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function add_controls( $wp_customize ) {
	    if ( empty( $this->contents ) ) {
	        return;
	    }
	    
	    foreach ( $this->contents as $content ) {
	        $content->add_controls( $wp_customize );
	    }
	}

	/**
     * Title positions
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Title positions
     */
    public function title_positions() {
        return array(
            'side' => esc_html__( 'Side', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
        );
    }
    
    /**
     * Image alignments
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Image alignments
     */
    public function image_alignments() {
        return array(
            'none' => esc_html__( 'none', 'jentil' ),
            'left' => esc_html__( 'Left', 'jentil' ),
            'right' => esc_html__( 'Right', 'jentil' ),
        );
    }
    
    /**
     * Pagination positions
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Pagination positions
     */
    public function pagination_positions() {
        return array(
            'none' => esc_html__( 'None', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
            'bottom' => esc_html__( 'Bottom', 'jentil' ),
            'top_bottom' => esc_html__( 'Top and bottom', 'jentil' ),
        );
    }

    /**
     * Layouts
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Layouts
     */
    public function layouts() {
        return array(
            'stack' => esc_html__( 'Stack', 'jentil' ),
            'grid' => esc_html__( 'Grid', 'jentil' ),
        );
    }
}