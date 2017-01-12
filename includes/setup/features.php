<?php

/**
 * Features
 *
 * Add support for theme features
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack\Utilities\Singleton;

/**
 * Features
 *
 * Add support for theme features
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Features extends Singleton {
    /**
     * Content width
     * 
     * Set the content width based on the theme's design
     * and stylesheet.
     *
     * @since       jentil 0.1.0
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function set_content_width() {
        if ( ! isset( $content_width ) ) {
            $content_width = 600; /* pixels */
        }
    }
    
    /**
     * Translations.
     *
     * Make theme available for translation. Translations can
     * be filed in the '/languages' directory.
     *
     * @since 		jentil 0.1.0
	 * @access 		public
	 * 
	 * @action      after_setup_theme
     */
    public function enable_translation() {
	    load_theme_textdomain( 'jentil', get_template_directory() . '/languages' );
    }
    
    /**
     * Title tag.
     * 
     * Add support for the title tag.
     *
     * @since 		jentil 0.1.0
     * @since 		WordPress 4.1
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function enable_title_tag() {
    	if ( ! function_exists( 'wp_get_document_title' ) ) {
    		return;
    	}
    
    	add_theme_support( 'title-tag' );
    }
    
    /**
     * Widget areas
     * 
     * Register widgetized areas for this theme.
     * 
     * @since 		jentil 0.1.0
     * @access 		public
     * 
     * @action      widgets_init
     */
    public function register_widget_areas() {
    	/** Primary Sidebar */
    	register_sidebar( array(
    		'name'          => esc_html__( 'Primary', 'jentil' ),
    		'id'            => 'primary-widget-area',
    		'description'   => esc_html__( 'Primary widget area', 'jentil' ),
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => '<h3 class="widget-title">',
    		'after_title'   => '</h3>',
    	) );
    	
    	/** Secondary Sidebar */
    	register_sidebar( array(
    		'name'          => esc_html__( 'Secondary', 'jentil' ),
    		'id'            => 'secondary-widget-area',
    		'description'   => esc_html__( 'Secondary widget area', 'jentil' ),
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => '<h3 class="widget-title">',
    		'after_title'   => '</h3>',
    	) );
    	
    	/** Footer area */
        register_sidebar( array(
        	'name'          => esc_html__( 'Footer', 'jentil' ),
        	'id'            => 'footer-widget-area',
    		'description'   => esc_html__( 'Footer widget area', 'jentil' ),
        	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        	'after_widget'  => '</aside>',
        	'before_title'  => '<h3 class="widget-title">',
        	'after_title'   => '</h3>',
    	) );
    }
    
    /**
     * HTML5
     * 
     * Add support for html5 markup for certain features
     *
     * @see 		https://codex.wordpress.org/Theme_Markup
     *
     * @since 		jentil 0.1.0
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function enable_html5() {
    	add_theme_support( 'html5', array(
    		'search-form',
    		'comment-form',
    		'comment-list',
    		'gallery',
    		'caption',
    		'widgets',
    	) );
    }
    
    /**
     * Selective refresh
     * 
     * Add selective refresh support to elements
     * in the customizer.
     * 
     * @see 		https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
     *
     * @since 		jentil 0.1.0
     * @since       WordPress 4.5
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function enable_customizer_selective_refresh() {
    	add_theme_support( 'customize-selective-refresh-widgets' );
    }
    
    /**
     * Menus
     * 
     * Register navigation menus
     * 
     * @since 		jentil 0.1.0
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function register_menus() {
      	register_nav_menus( array(
        	'primary-menu' => esc_html__( 'Primary menu', 'jentil' ),
    	) );
    }
    
    /**
     * Feeds
     * 
     * Add support for RSS and atom feeds
     * 
     * @since 		jentil 0.1.0
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function add_feed_support() {
    	add_theme_support( 'automatic-feed-links' );
    }
    
    /**
     * Featured images
     * 
     * Add support for featured images (post thumbnails).
     * 
     * @since 		jentil 0.1.0
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function enable_featured_images() {
    	add_theme_support( 'post-thumbnails' );
    }
    
    /**
     * Image sizes
     * 
     * Add/set sizes of featured images.
     * 
     * @since 		jentil 0.1.0
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function add_image_sizes() {
        set_post_thumbnail_size( 480, 260, true );
        
    	add_image_size( 'mini-thumb', 100, 100, true );
    	add_image_size( 'micro-thumb', 75, 75, true );
    	add_image_size( 'nano-thumb', 50, 50, true );
    }
    
    /**
     * Logo
     * 
     * Add support for custom logos.
     * Use this in child themes, rather?
     * 
     * @see         https://codex.wordpress.org/Theme_Logo
     * 
     * @since 		jentil 0.1.0
     * @since       WordPress 4.5
     * @access 		public
     * 
     * @action      after_setup_theme
     */
    public function enable_custom_logo() {
        add_theme_support( 'custom-logo', array(
           'height'      => 60,
           'width'       => 180,
        ) );
    }
}