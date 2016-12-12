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
 * @since		    Jentil 0.1.0
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
 * @since			jentil 0.1.0
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
		$this->parts();
		$this->customizer();
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
	private function parts() {
		$parts = new Parts();
		
		add_filter( 'language_attributes', array( $parts, 'html_microdata' ) );
		add_filter( 'get_search_form', array( $parts, 'search_form' ) );
		add_filter( 'single_post_entry_meta', array( $parts, 'single_post_entry_meta' ), 10, 3 );
		add_filter( 'body_class', array( $parts, 'body_class' ) );
		
		add_action( 'jentil_before_title', array( $parts, 'breadcrumbs' ) );
		
		add_action( 'jentil_inside_header', array( $parts, 'header_logo' ) );
		add_action( 'jentil_inside_header', array( $parts, 'header_search' ) );
		add_action( 'jentil_inside_header', array( $parts, 'header_menu' ) );
		
		add_action( 'jentil_inside_footer', array( $parts, 'footer_widgets' ) );
		add_action( 'jentil_inside_footer', array( $parts, 'footer_credits' ) );
	}
	
	/**
     * Define customizer hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function customizer() {
		$customizer = new Customizer\Customizer();
		
		add_action( 'customize_register', array( $customizer, 'register' ) );
		add_action( 'customize_preview_init', array( $customizer, 'live_preview' ) );
	}
}