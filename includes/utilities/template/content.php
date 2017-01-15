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
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Template $template ) {
	    $this->template = $template;
	}
	
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
    public function get_mod( $setting, $default = '' ) {
        if ( ! ( $name = $this->get_mod_name( $setting ) ) ) {
            return false;
        }

        return get_theme_mod( $name, $default );
    }

    /**
     * Get setting name
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @return      string          Setting name
     */
    public function get_mod_name( $setting ) {
        $name = '';

        if ( $this->template->is( 'tax' ) ) {
            $name = get_query_var( 'taxonomy' ) . '_taxonomy_content_' . $setting;
        } elseif ( $this->template->is( 'category' ) ) {
            $name = 'category_taxonomy_content_' . $setting;
        } elseif ( $this->template->is( 'tag' ) ) {
            $name = 'tag_taxonomy_content_' . $setting;
        } elseif ( $this->template->is( 'post_type_archive' ) ) {
            $name = get_query_var( 'post_type' ) . '_post_type_content_' . $setting;
        } elseif ( $this->template->is( 'home' ) ) {
            $name = 'post_post_type_content_' . $setting;
        } elseif ( $this->template->is( 'date' ) ) {
            $name = 'date_content_' . $setting;
        } elseif ( $this->template->is( 'search' ) ) {
            $name = 'search_content_' . $setting;
        } elseif ( $this->template->is( 'author' ) ) {
            $name = 'author_content_' . $setting;
        }

        return sanitize_key( $name );
    }
}