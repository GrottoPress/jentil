<?php

/**
 * Template
 *
 * This defines template-specific functions.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 1.0.0
 */

namespace GrottoPress\Jentil\Template;

/**
 * Template
 *
 * This defines template-specific functions.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
class Template {
    /**
     * Title
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $title       Template title
	 */
    private $title;
    
    /**
     * Layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $layout       Template layout
	 */
    private $layout;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct() {
	    $this->title = new Title( $this->get() );
	    $this->layout = new Layout( $this->get() );
	}
    
    /**
	 * Add breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function templates() {
		return array(
			'home',
			'front_page',
			'single',
			'page',
			'attachment',
			'singular',
			'author',
			'category',
			'day',
			'month',
			'year',
			'date',
			'post_type_archive',
			'tag',
			'tax',
			'404',
			'search',
		);
	}
	
	/**
	 * Are we on a particular template?
	 * 
	 * @var 		string			$template		Template name/slug
	 * @var 		mixed			$args			Arguments to the is_{template} functions in WordPress
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function is( $template, $args = '' ) {
		if ( empty( $this->get() ) ) {
			return false;
		}
		
		$is_this_template = in_array( $template, $this->get() );
		
		if ( empty( $args ) ) {
			return $is_this_template;
		}
		
		$is_template = 'is_' . $template;
		
		if ( $is_this_template && is_callable( $is_template ) ) {
			return $is_template( $args );
		}
		
		return false;
	}
	
	/**
	 * Get template
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @return		array			Template tags applicable to this template
	 */
	private function get() {
		$return = array();
		
		if ( empty( $this->templates() ) ) {
			return $return;
		}
		
		foreach ( $this->templates() as $template ) {
	    	$is_template = 'is_' . $template;
	    	
	    	if ( is_callable( $is_template ) ) {
	    		if ( $is_template() ) {
	    			$return[] = $template;
	    		}
	    	}
	    }
	    
	    return $return;
	}
    
    /**
     * Template title
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function title() {
		return $this->title->get();
	}
	
	/**
     * Template layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function layout() {
		return $this->layout->get();
	}
	
	/**
     * Get template title
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function get_title() {
		return $this->title;
	}
	
	/**
     * Get template layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function get_layout() {
		return $this->layout;
	}
}