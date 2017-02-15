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

use GrottoPress\MagPack;

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
final class Content extends MagPack\Utilities\Wizard {
    /**
     * Template
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Template         $template       Template
	 */
    protected $template;
    
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
    public function mod( $setting, $default = '' ) {
        if ( ! ( $name = $this->mod_name( $setting ) ) ) {
            return false;
        }

        return get_theme_mod( $name, $default );
    }

    /**
     * Get setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Setting name
     */
    private function mod_name( $setting ) {
        $name = '';

        if ( $this->template->is( 'category' ) ) {
            $name = 'category_taxonomy_content_' . $setting;
        } elseif ( $this->template->is( 'tag' ) ) {
            $name = 'tag_taxonomy_content_' . $setting;
        } elseif ( $this->template->is( 'tax' ) ) {
            $name = get_query_var( 'taxonomy' ) . '_taxonomy_content_' . $setting;
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

    /**
     * Get default mod
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Default mod
     */
    private function mod_default( $setting ) {

    }
}