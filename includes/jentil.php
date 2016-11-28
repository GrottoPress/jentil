<?php

/**
 * jentil
 *
 * This hooks methods into actions and filters
 * that enables standard theme functionality.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 1.0.0
 */

namespace GrottoPress\Jentil;

/**
 * Jentil
 *
 * This hooks methods into actions and filters
 * that enables standard theme functionality.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
class Jentil {
    /**
     * Run the theme
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function run() {
		$this->setup();
		$this->template_parts();
	}

    /**
     * Define setup hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function setup() {
		$setup = new Setup();
		
		add_action( 'after_setup_theme', array( $setup, 'set_content_width' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_translation' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_title_tag' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_html5' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_customizer_selective_refresh' ) );
		add_action( 'after_setup_theme', array( $setup, 'register_menus' ) );
		add_action( 'after_setup_theme', array( $setup, 'add_feed_support' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_featured_images' ) );
		add_action( 'after_setup_theme', array( $setup, 'add_image_sizes' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_custom_logo' ) );
		
		add_action( 'wp_enqueue_scripts', array( $setup, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $setup, 'enqueue_styles' ) );
		
		add_action( 'wp_head', array( $setup, 'render_title' ) );
		add_action( 'widgets_init', array( $setup, 'register_widget_areas' ) );
	}
	
	/**
     * Define template parts hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function template_parts() {
		$template = new Template_Parts();
		
		add_filter( 'language_attributes', array( $template, 'html_microdata' ) );
		add_filter( 'get_search_form', array( $template, 'search_form' ) );
		add_filter( 'single_post_entry_meta', array( $template, 'single_post_entry_meta' ), 10, 3 );
		add_filter( 'body_class', array( $template, 'body_class' ) );
		
		add_action( 'jentil_before_title', array( $template, 'breadcrumbs' ) );
		
		add_action( 'jentil_inside_header', array( $template, 'header_logo' ) );
		add_action( 'jentil_inside_header', array( $template, 'header_search' ) );
		add_action( 'jentil_inside_header', array( $template, 'header_menu' ) );
		
		add_action( 'jentil_inside_footer', array( $template, 'footer_widgets' ) );
		add_action( 'jentil_inside_footer', array( $template, 'footer_credits' ) );
	}
}