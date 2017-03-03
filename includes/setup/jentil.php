<?php

/**
 * Jentil
 *
 * This hooks methods into actions and filters
 * that enables standard theme functionality.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Jentil
 *
 * This hooks methods into actions and filters
 * that enables standard theme functionality.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/setup
 * @since			Jentil 0.1.0
 */
final class Jentil extends MagPack\Utilities\Singleton {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    protected function __construct() {}

    /**
     * Run the theme
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function run() {
		$this->language();
		$this->features();
		$this->enqueue();
		$this->layout();
		$this->logo();

		$this->parts();
		$this->customizer();
		$this->metaboxes();
	}

	/**
     * Define language hooks
	 *
	 * @since       MagPack 0.1.0
	 * @access      private
	 */
	private function language() {
		$language = Language::instance( $this );
		
		add_action( 'after_setup_theme', array( $language, 'enable_translation' ) );
	}

    /**
     * Define setup hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function features() {
		$setup = Features::instance( $this );
		
		add_action( 'after_setup_theme', array( $setup, 'set_content_width' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_title_tag' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_html5' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_customizer_selective_refresh' ) );
		add_action( 'after_setup_theme', array( $setup, 'register_menus' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_feeds' ) );
		add_action( 'after_setup_theme', array( $setup, 'enable_featured_images' ) );
		add_action( 'after_setup_theme', array( $setup, 'add_image_sizes' ) );
		
		add_action( 'widgets_init', array( $setup, 'register_widget_areas' ) );
	}

	/**
     * Define layout hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function layout() {
		$layout = Layout::instance( $this );
		
		add_filter( 'body_class', array( $layout, 'body_class' ) );
	}

	/**
     * Define logo hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function logo() {
		$logo = Logo::instance( $this );

		add_action( 'after_setup_theme', array( $logo, 'enable' ) );
		add_action( 'jentil_inside_header', array( $logo, 'render' ) );
	}

	/**
     * Define template parts hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function parts() {
		$parts = Parts::instance( $this );
		
		add_filter( 'language_attributes', array( $parts, 'html_microdata' ) );
		add_filter( 'get_search_form', array( $parts, 'search_form' ) );
		add_filter( 'body_class', array( $parts, 'body_class' ) );

		add_action( 'wp_head', array( $parts, 'render_title' ) );

		add_action( 'jentil_before_title', array( $parts, 'breadcrumbs' ) );
		// add_action( 'jentil_before_title', array( $parts, 'post_parent_link' ) );
		add_action( 'jentil_before_content', array( $parts, 'attachment' ) );

		add_filter( 'jentil_singular_after_title', array( $parts, 'single_post_after_title' ), 10, 3 );
		add_action( 'jentil_after_title', array( $parts, 'single_post_after_title_echo' ) );

		add_action( 'jentil_inside_header', array( $parts, 'header_logo' ) );
		add_action( 'jentil_inside_header', array( $parts, 'header_search' ) );
		add_action( 'jentil_inside_header', array( $parts, 'header_menu' ) );
		add_action( 'jentil_inside_header', array( $parts, 'mobile_header_menu_toggle' ) );

		add_action( 'jentil_after_header', array( $parts, 'mobile_header_menu' ), 100 );
		add_action( 'jentil_inside_footer', array( $parts, 'footer_widgets' ), 100 );
		add_action( 'jentil_inside_footer', array( $parts, 'colophon' ), 200 );
	}

	/**
     * Define setup hooks
	 *
	 * @since       MagPack 0.1.0
	 * @access      private
	 */
	private function enqueue() {
		$enqueue = Enqueue::instance( $this );
		
		add_action( 'wp_enqueue_scripts', array( $enqueue, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $enqueue, 'styles' ) );
	}
	
	/**
     * Define customizer hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function customizer() {
		$customizer = Customizer\Customizer::instance( $this );
		
		add_action( 'customize_register', array( $customizer, 'add' ) );
		add_action( 'customize_preview_init', array( $customizer, 'enqueue' ) );
	}
	
	/**
     * Define meta boxes hooks
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function metaboxes() {
		$boxes = Metaboxes::instance( $this );
		
		add_action( 'load-post.php', array( $boxes, 'setup' ) );
		add_action( 'load-post-new.php', array( $boxes, 'setup' ) );
	}
}