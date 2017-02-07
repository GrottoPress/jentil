<?php

/**
 * Template
 *
 * This defines template-specific functions.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/utilities
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Template
 *
 * This defines template-specific functions.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/utilities
 * @since			Jentil 0.1.0
 */
final class Template extends MagPack\Utilities\Wizard {
    /**
     * Title
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Title         $title       Template title
	 */
    protected $title;
    
    /**
     * Layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Layout         $layout       Template layout
	 */
    protected $layout;

    /**
     * Content
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Content         $content       Template content
	 */
    protected $content;

    /**
     * Posts
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var 	\GrottoPress\Jentil\Utilities\Template\Posts 	$posts 		Template posts
	 */
    protected $posts;

    /**
     * Breadcrumbs
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var 	\GrottoPress\MagPack\Utilities\Template\Breadcrumbs 	$breadcrumbs 	Breadcrumbs
	 */
    protected $breadcrumbs;
    
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
	    $this->posts = new Posts( $this );
	}

	/**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       MagPack 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return array( 'title', 'layout', 'content', 'posts' );
    }

    /**
	 * Breadcrumbs
	 * 
	 * @since       MagPack 0.1.0
	 * @access      public
	 *
	 * @return 	\GrottoPress\MagPack\Utilities\Template\Breadcrumbs 	Breadcrumbs
	 */
	public function breadcrumbs( $args = '' ) {
		$this->breadcrumbs = new Breadcrumbs( $this, $args );

		return $this->breadcrumbs;
	}

	/**
	 * Get template type
	 * 
	 * @since       MagPack 0.1.0
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
	    	if ( $this->is( $template ) ) {
	    		$return[] = $template;
	    	}
	    }
	    
	    return $return;
	}

	/**
	 * Are we on a particular template?
	 * 
	 * @var 		string			$template		Template name/slug
	 * @var 		mixed			$args			Arguments to the is_{template} functions in WordPress
	 * 
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	public function is( $template, $args = '' ) {
		if ( ! in_array( $template, $this->templates() ) ) {
			return false;
		}

		$is_template = 'is_' . $template;

		if ( is_callable( $is_template ) ) {
			return $is_template( $args );
		}
		
		return false;
	}

	/**
	 * Add breadcrumbs links
	 * 
	 * @since       MagPack 0.1.0
	 * @access      protected
	 */
	protected function templates() {
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
			'customize_preview',
			'admin',
		);
	}
}