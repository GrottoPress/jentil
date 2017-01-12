<?php

/**
 * Content
 * 
 * Template content
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Content
 * 
 * Template content
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Content {
    /**
     * Template
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Template         $template       Template
	 */
    private $template;
    
    /**
     * Context
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         string         $context       Context
	 */
    private $context;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Template $template, $context = '' ) {
	    $this->template = $template;
	    $this->context = sanitize_key( $context );
	}

    // $this->template->is( 'search' )
    //         ? 'search' : sanitize_key( get_query_var( 'post_type' ) );
	
	/**
     * Get setting
     * 
     * @var         string      $setting        Setting to retrieve
     * @var         mixed       $default        Default setting
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      mixed          Setting value
     */
    public function get( $setting, $default = '' ) {
        $setting_name = $setting . '_name';

        if ( ! is_callable( array( $this, $setting_name ) ) ) {
            return false;
        }

        return get_theme_mod( $this->$setting_name( $this->context ), $default );
    }

    /**
     * Get sticky post setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          sticky posts setting name
     */
    public function sticky_posts_name( $template ) {
        return sanitize_key( $template . '_content_sticky_posts' );
    }

    /**
     * Get class setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Setting name
     */
    public function class_name( $template ) {
        return sanitize_key( $template . '_content_class' );
    }

    /**
     * Get layout setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Layout setting name
     */
    public function layout_name( $template ) {
        return sanitize_key( $template . '_content_layout' );
    }

    /**
     * Get number setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Number of posts setting name
     */
    public function number_name( $template ) {
        return sanitize_key( $template . '_content_number' );
    }

    /**
     * Get 'before_title' setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          'before_title' setting name
     */
    public function before_title_name( $template ) {
        return sanitize_key( $template . '_content_before_title' );
    }

    /**
     * Get title length setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Title length setting name
     */
    public function title_words_name( $template ) {
        return sanitize_key( $template . '_content_title_words' );
    }

    /**
     * Get title position setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Title position setting name
     */
    public function title_position_name( $template ) {
        return sanitize_key( $template . '_content_title_position' );
    }

    /**
     * Get after title setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          After title setting name
     */
    public function after_title_name( $template ) {
        return sanitize_key( $template . '_content_after_title' );
    }

    /**
     * Get thumbnail size setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Thumbnail size setting name
     */
    public function thumbnail_name( $template ) {
        return sanitize_key( $template . '_content_thumbnail' );
    }

    /**
     * Get thumbnail alignment setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Thumbnail alignment setting name
     */
    public function thumbnail_alignment_name( $template ) {
        return sanitize_key( $template . '_content_thumbnail_alignment' );
    }

    /**
     * Get text offset setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Text offset setting name
     */
    public function text_offset_name( $template ) {
        return sanitize_key( $template . '_content_text_offset' );
    }

    /**
     * Get excerpt length setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Excerpt length setting name
     */
    public function excerpt_name( $template ) {
        return sanitize_key( $template . '_content_excerpt' );
    }

    /**
     * Get after content setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          After content setting name
     */
    public function after_content_name( $template ) {
        return sanitize_key( $template . '_content_after_content' );
    }

    /**
     * Get pagination setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Pagination setting name
     */
    public function pagination_name( $template ) {
        return sanitize_key( $template . '_content_pagination' );
    }
}