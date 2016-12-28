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

namespace GrottoPress\Jentil\Template;

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
	 * @var         array         $template       Template
	 */
    private $template;
    
    /**
     * Search or archive
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         string         $template_       Search or archive
	 */
    private $template_;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $template ) {
	    $this->template = (array) $template;
	    $this->template_ = in_array( 'search', $this->template ) ? 'search' : 'archive';
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
            'top' => esc_html__( 'Top', 'jentil' ),
            'bottom' => esc_html__( 'Bottom', 'jentil' ),
            'top_bottom' => esc_html__( 'Top and bottom', 'jentil' ),
        );
    }
	
	/**
     * Get setting
     * 
     * @var         string      $setting        Setting to retrieve
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      mixed          Setting value
     */
    public function get( $setting ) {
        $setting = sanitize_key( $setting );
        
        if ( ! is_callable( array( $this, $setting ) ) ) {
            return false;
        }
        
        return $this->$setting();
    }
	
	/**
     * Get sticky posts setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Sticky posts setting
     */
    private function sticky_posts() {
        return absint( get_theme_mod( $this->template_ . '_sticky_posts' ) );
    }
    
    /**
     * Get 'before title' setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          'Before title' setting
     */
    private function before_title() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_before_title' ) );
    }
    
    /**
     * Get 'title length' setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      integer          Title length
     */
    private function title() {
        return (int) get_theme_mod( $this->template_ . '_title' );
    }
    
    /**
     * Get title position setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Title position
     */
    private function title_position() {
        return sanitize_key( get_theme_mod( $this->template_ . '_title_position' ) );
    }
    
    /**
     * Get 'after title' setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          After title
     */
    private function after_title() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_after_title' ) );
    }
    
    /**
     * Get thumbnail setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Thumbnail size
     */
    private function thumbnail() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_thumbnail' ) );
    }
    
    /**
     * Get thumbnail alignment setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Thumbnail alignment
     */
    private function thumbnail_alignment() {
        return sanitize_key( get_theme_mod( $this->template_ . '_thumbnail_alignment' ) );
    }
    
    /**
     * Get text offset setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      integer          Text offset relative to image side
     */
    private function text_offset() {
        return absint( get_theme_mod( $this->template_ . '_text_offset' ) );
    }
    
    /**
     * Get excerpt length setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Excerpt length
     */
    private function excerpt() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_excerpt' ) );
    }
    
    /**
     * Get 'after content' setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          After content
     */
    private function after_content() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_after_content' ) );
    }
    
    /**
     * Get pagination setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Pagination
     */
    private function pagination() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_pagination' ) );
    }
    
    /**
     * Get 'class' setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Wrapper classes
     */
    private function classes() {
        return sanitize_text_field( get_theme_mod( $this->template_ . '_class' ) );
    }
}