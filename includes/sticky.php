<?php

/**
 * Sticky Posts
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Post;

/**
 * Sticky Posts
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Sticky {
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
     * Get 'before title' setting
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      string          'Before title' setting
     */
    private function before_title() {
        return sanitize_text_field( get_theme_mod( 'sticky_before_title' ) );
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
        return (int) get_theme_mod( 'sticky_title' );
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
        return sanitize_key( get_theme_mod( 'sticky_title_position' ) );
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
        return sanitize_text_field( get_theme_mod( 'sticky_after_title' ) );
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
        return sanitize_text_field( get_theme_mod( 'sticky_thumbnail' ) );
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
        return sanitize_key( get_theme_mod( 'sticky_thumbnail_alignment' ) );
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
        return absint( get_theme_mod( 'sticky_text_offset' ) );
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
        return sanitize_text_field( get_theme_mod( 'sticky_excerpt' ) );
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
        return sanitize_text_field( get_theme_mod( 'sticky_after_content' ) );
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
        return sanitize_text_field( get_theme_mod( 'sticky_pagination' ) );
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
        return sanitize_text_field( get_theme_mod( 'sticky_class' ) );
    }
}