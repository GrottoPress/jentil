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
    die;
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
final class Template {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard, MagPack\Utilities\Singleton;

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
     * Breadcrumbs
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Utilities\Template\Breadcrumbs     $breadcrumbs    Breadcrumbs
     */
    protected $breadcrumbs;

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
        return [ 'title', 'layout', 'posts' ];
    }

    /**
     * Breadcrumbs
     *
     * @var         array       $args       Breadcrumb args supplied as associative array
     * 
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @return  \GrottoPress\Jentil\Utilities\Template\Breadcrumbs     Breadcrumbs
     */
    public function breadcrumbs( $args = [] ) {
        $this->breadcrumbs = new Breadcrumbs( $this, $args );

        return $this->breadcrumbs;
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

    /**
     * Get template type
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @return      array           Template tags applicable to this template
     */
    public function type() {
        $return = [];
        
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
     * @var         string      $template       Template name/slug
     * @var         mixed       $args           Arguments to the is_{template} functions in WordPress
     * @var         mixed       $args2          Arguments to the is_{template} functions in WordPress
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function is( $template, $args = '', $args2 = '' ) {
        if ( ! in_array( $template, $this->templates() ) ) {
            return false;
        }

        global $pagenow;

        if ( 'login' == $template ) {
            return ( $pagenow === 'wp-login.php' );
        }

        if ( 'register' == $template ) {
            return ( $pagenow === 'wp-signup.php' );
        }

        $is_template = 'is_' . $template;

        if ( is_callable( $is_template ) ) {
            return $is_template( $args, $args2 );
        }
        
        return false;
    }

    /**
     * Add breadcrumbs links
     * 
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function templates() {
        return [
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
            'login',
            'register',
        ];
    }
}