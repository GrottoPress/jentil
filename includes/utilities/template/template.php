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
final class Template extends MagPack\Utilities\Template\Template {
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
     * Posts
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var 	\GrottoPress\Jentil\Utilities\Template\Posts 	$posts 		Template posts
	 */
    protected $posts;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 */
	protected function __construct() {
	    $this->title = new Title( $this );
	    $this->layout = new Layout( $this );
	    $this->posts = new Posts( $this );

	    parent::__construct();
	}

	/**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       Jentil 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return array_merge( parent::allow_get(), array( 'title', 'layout', 'posts' ) );
    }

    /**
     * Description
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return      string       Description.
     */
    public function description() {
        if ( $this->is( 'category' ) ) {
            return category_description();
        }

        if ( $this->is( 'tag' ) ) {
            return tag_description();
        }

        if ( $this->is( 'tax' ) ) {
            return term_description();
        }

        if ( $this->is( 'author' ) ) {
            return get_the_author_meta( 'description' );
        }

        if ( $this->is( 'singular' ) ) {
            return get_the_excerpt();
        }

        return '';
    }
}