<?php

/**
 * Template title
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 1.0.0
 */

namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Template
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
final class Title extends MagPack\Utilities\Wizard {
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
     * Get page title
     * 
	 * Defines the page title depending on what template
	 * we're on.
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function title() {
		$title = get_bloginfo( 'name' );
		
		if ( ! ( $type = $this->template->type() ) ) {
			return $title;
		}
		
		foreach ( $type as $template ) {
			$template_title = $template . '_title';
    		$title_template = 'title_' . $template;
    		
    		if ( is_callable( array( $this, $template_title ) ) ) {
				$title = $this->$template_title();
				break;
			} elseif ( is_callable( array( $this, $title_template ) ) ) {
				$title = $this->$title_template();
				break;
			}
		}
		
		return apply_filters( 'jentil_template_title', $title, $template );
	}
	
	/**
	 * Category title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function category_title() {
		return sprintf( esc_html__( 'Category: %s', 'jentil' ), '<span>' . single_cat_title( '', false ) . '</span>' );
	}
	
	/**
	 * Tag title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function tag_title() {
		return sprintf( esc_html__( 'Tag: %s', 'jentil' ), '<span>' . single_tag_title( '', false ) . '</span>' );
	}
	
	/**
	 * Author title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function author_title() {
		$author_id = get_query_var( 'author' );
			
		return sprintf( esc_html__( 'Author: %s', 'jentil' ), '<span class="vcard"><!--<a class="url fn n" href="' . get_author_posts_url( $author_id ) . '" title="' . esc_attr( get_the_author_meta( 'display_name', $author_id ) ) . '" rel="me">-->' . esc_attr( get_the_author_meta( 'display_name', $author_id ) ) . '<!--</a>--></span>' );
	}
	
	/**
	 * Day title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function day_title() {
		return sprintf( esc_html__( 'Day: %s', 'jentil' ), '<span>' . get_the_date() . '</span>' );
	}
	
	/**
	 * Month title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function month_title() {
		return sprintf( esc_html__( 'Month: %s', 'jentil' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
	}
	
	/**
	 * Year title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function year_title() {
		return sprintf( esc_html__( 'Year: %s', 'jentil' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
	}
	
	/**
	 * Taxonomy title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function tax_title() {
		$tax_slug = get_query_var( 'taxonomy' );
		$tax_name = $tax_slug ? get_taxonomy( $tax_slug )->labels->singular_name : '';
		
		return sprintf( esc_html__( '%1$s: %2$s', 'jentil' ), $tax_name, '<span>' . single_term_title( '', false ) . '</span>' );
	}
	
	/**
	 * Post type archive title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function post_type_archive_title() {
		return sprintf( esc_html__( '%s', 'jentil' ), '<span>' . trim( post_type_archive_title( '', false ) ) . '</span>' );
	}
	
	/**
	 * Singular title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function singular_title() {
		return '<span>' . trim( single_post_title( '', false ) ) . '</span>';
	}
	
	/**
	 * Search title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function search_title() {
		return sprintf( esc_html__( 'Search: %1$s', 'jentil' ), '<span>&ldquo;' . get_search_query() . '&rdquo;</span>' );
	}
	
	/**
	 * Home title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function home_title() {
		if ( is_front_page() ) {
			return sprintf( esc_html__( 'Latest Posts on %s', 'jentil' ), get_bloginfo( 'name' ) );
		} else {
			return esc_html__( 'Latest Posts', 'jentil' );
		}
	}
	
	/**
	 * 404 title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function title_404() {
		return esc_html__( 'Not Found', 'jentil' );
	}
}