<?php

/**
 * Content customizer
 *
 * The sections, settings and controls for our Content
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Customizer\Content;

/**
 * Content customizer
 *
 * The sections, settings and controls for our Content
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Content {
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
	public function __construct() {
        $this->contents = $this->contents();
	}
	
	/**
	 * Templates
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function contents() {
	    $contents = array();
	    
	    $contents[] = new Archive();
	    $contents[] = new Search();
	    $contents[] = new Sticky();
	    
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
}