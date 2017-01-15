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

namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

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
	 * @var         \GrottoPress\Jentil\Utilities\Template\Title         $title       Template title
	 */
    private $title;
    
    /**
     * Layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Layout         $layout       Template layout
	 */
    private $layout;

    /**
     * Content
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Content         $content       Template content
	 */
    private $content;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct() {
	    $this->title = new Title( $this );
	    $this->layout = new Layout( $this );
	    $this->content = new Content( $this );
	}

	/**
     * Get attributes
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function get( $attribute ) {
        $disallow = array();

        if ( in_array( $attribute, $disallow ) ) {
            return null;
        }

        return $this->$attribute;
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
			'archive',
			'404',
			'search',
			// 'customize_preview',
			// 'admin',
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
		if ( ! ( $type = $this->type() ) ) {
			return false;
		}
		
		$is_this_template = in_array( $template, $type );
		
		if ( empty( $args ) ) {
			return $is_this_template;
		}
		
		$function = 'is_' . $template;
		
		if ( $is_this_template && is_callable( $function ) ) {
			return $function( $args );
		}
		
		return false;
	}
	
	/**
	 * Get template type
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return		array			Template tags applicable to this template
	 */
	public function type() {
		$return = array();
		
		if ( ! ( $templates = $this->templates() ) ) {
			return $return;
		}
		
		foreach ( $templates as $template ) {
	    	$function = 'is_' . $template;
	    	
	    	if ( is_callable( $function ) ) {
	    		if ( $function() ) {
	    			$return[] = $template;
	    		}
	    	}
	    }
	    
	    return $return;
	}
}