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
		$this->enqueue();
		$this->thumbnails();
		$this->feeds();
		$this->HTML5();
		$this->title_tag();
		$this->layout();
		$this->logo();
		$this->search();
		$this->menus();
		$this->breadcrumbs();
		$this->posts();
		$this->widgets();
		$this->colophon();
		$this->customizer();
		$this->metaboxes();
	}

	/**
     * Language
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function language() {
		$language = Language::instance( $this );
		
		add_action( 'after_setup_theme', array( $language, 'enable_translation' ) );
	}

    /**
     * Enqueue
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function enqueue() {
		$enqueue = Enqueue::instance( $this );
		
		add_action( 'wp_enqueue_scripts', array( $enqueue, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $enqueue, 'styles' ) );
	}

	/**
     * Thumbnails
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function thumbnails() {
		$thumbnails = Thumbnails::instance( $this );
		
		add_action( 'after_setup_theme', array( $thumbnails, 'enable' ) );
		add_action( 'after_setup_theme', array( $thumbnails, 'sizes' ) );
	}

	/**
     * Feeds (Atom, RSS etc)
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function feeds() {
		$feeds = Feeds::instance( $this );
		
		add_action( 'after_setup_theme', array( $feeds, 'enable' ) );
	}

	/**
     * HTML5
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function HTML5() {
		$HTML5 = HTML5::instance( $this );
		
		add_action( 'after_setup_theme', array( $HTML5, 'enable' ) );
		add_filter( 'language_attributes', array( $HTML5, 'html_tag_schema' ) );
	}

	/**
     * Title tag
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function title_tag() {
		$title_tag = Title_Tag::instance( $this );
		
		add_action( 'after_setup_theme', array( $title_tag, 'enable' ) );
		add_action( 'wp_head', array( $title_tag, 'render' ) );
	}

	/**
     * Layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function layout() {
		$layout = Layout::instance( $this );
		
		add_filter( 'body_class', array( $layout, 'body_class' ) );
	}

	/**
     * Logo
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
     * Search
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function search() {
		$search = Search::instance( $this );

		add_action( 'get_search_form', array( $search, 'form' ) );
		add_action( 'jentil_inside_header', array( $search, 'render' ) );
	}

	/**
     * Menus
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function menus() {
		$menus = Menus::instance( $this );

		add_action( 'after_setup_theme', array( $menus, 'register' ) );
		add_action( 'jentil_inside_header', array( $menus, 'header_menu' ) );
		add_action( 'jentil_inside_header', array( $menus, 'mobile_header_menu_toggle' ) );
		add_action( 'jentil_after_header', array( $menus, 'mobile_header_menu' ) );
	}

	/**
     * Breadcrumbs
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function breadcrumbs() {
		$breadcrumbs = Breadcrumbs::instance( $this );

		add_action( 'jentil_before_title', array( $breadcrumbs, 'render' ) );
	}

	/**
     * Posts
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function posts() {
		$posts = Posts::instance( $this );
		
		add_filter( 'body_class', array( $posts, 'body_class' ) );
		// add_action( 'jentil_before_title', array( $parts, 'post_parent_link' ) );
		add_action( 'jentil_before_content', array( $posts, 'attachment' ) );
		// add_filter( 'jentil_singular_after_title', array( $posts, 'single_post_after_title_' ), 10, 3 );
		add_action( 'jentil_after_title', array( $posts, 'single_post_after_title' ) );
	}

	/**
     * Widgets
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function widgets() {
		$widgets = Widgets::instance( $this );

		add_action( 'widgets_init', array( $widgets, 'register' ) );
		add_action( 'jentil_inside_footer', array( $widgets, 'footer_widgets' ) );
	}

	/**
     * Colophon
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function colophon() {
		$colophon = Colophon::instance( $this );

		add_action( 'jentil_inside_footer', array( $colophon, 'render' ) );
	}

	/**
     * Customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function customizer() {
		$customizer = Customizer\Customizer::instance( $this );
		
		add_action( 'customize_register', array( $customizer, 'add' ) );
		add_action( 'customize_preview_init', array( $customizer, 'enqueue' ) );
		add_action( 'after_setup_theme', array( $customizer, 'selective_refresh' ) );
	}
	
	/**
     * Metaboxes
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