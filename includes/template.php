<?php

/**
 * Template
 *
 * This defines template-specific functions.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 1.0.0
 */

namespace GrottoPress\Jentil;

/**
 * Template
 *
 * This defines template-specific functions.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
class Template {
    /**
     * Page title
     * 
	 * Defines the page title depending on what template
	 * we're on.
	 *
	 * @since       MapPess 1.0.0
	 * @access      public
	 */
	public function title() {
		if ( is_category() ) {
			$title = sprintf( esc_html__( 'Category Archive: %s', 'jentil' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( 'Tag Archive: %s', 'jentil' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		} elseif ( is_author() ) {
			$author_id = get_query_var( 'author' );
			
			$title = sprintf( esc_html__( 'Author Archive: %s', 'jentil' ), '<span class="vcard"><!--<a class="url fn n" href="' . get_author_posts_url( $author_id ) . '" title="' . esc_attr( get_the_author_meta( 'display_name', $author_id ) ) . '" rel="me">-->' . esc_attr( get_the_author_meta( 'display_name', $author_id ) ) . '<!--</a>--></span>' );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Daily Archive: %s', 'jentil' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Monthly Archive: %s', 'jentil' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Yearly Archive: %s', 'jentil' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		} elseif ( is_tax() ) {
			$tax_slug = get_query_var( 'taxonomy' );
            $tax_name = ! empty( $tax_slug ) ? get_taxonomy( $tax_slug )->labels->singular_name : '';
            
            $title = sprintf( esc_html__( '%1$s Archive: %2$s', 'jentil' ), $tax_name, '<span>' . single_term_title( '', false ) . '</span>' );
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( esc_html__( '%s Archive', 'jentil' ), '<span>' . trim( post_type_archive_title( '', false ) ) . '</span>' );
		} elseif ( is_singular() ) {
			$title = '<span>' . trim( single_post_title( '', false ) ) . '</span>';
		} elseif ( is_search() ) {
			$title = sprintf( esc_html__( 'Search Results: %1$s', 'jentil' ), '<span>&ldquo;' . get_search_query() . '&rdquo;</span>' );
		} elseif ( is_home() && is_front_page() ) {
			$title = sprintf( esc_html__( 'Latest Posts on %s', 'jentil' ), get_bloginfo( 'name' ) );
		} elseif ( is_home() ) {
			$title = esc_html__( 'Latest Posts', 'jentil' );
		} elseif ( is_404() ) {
		    $title = esc_html__( 'Page Not Found', 'jentil' );
		} else {
			$title = get_bloginfo( 'name' );
		}
		
		return apply_filters( 'jentil_template_title', $title );
	}
	
	/**
	 * Get Layout Column
	 * 
	 * This get the number of columns that makes the layout
	 * Valid columns are: 'one_column', 'two_columns', 'three_columns'.
	 * 
	 * @var         $layout         The layout type
	 * 
	 * @since       MagPack 1.0.0
	 * @access      public
	 * 
	 * @return      string      Layout column type
	 */
	public function layout_column( $layout ) {
	    
	}
	
	/**
     * Get Layout
     * 
     * @since		jentil 1.0.0
     * @access      public
     * 
     * @return      string      The layout type
     */
    public function layout() {
        global $post;
        $default = 'content_sidebar';
        
        if ( is_singular() && is_post_type_hierarchical( $post->post_type ) ) {
        	$layout = get_post_meta( $post->ID, 'jentil_layout', true );
        } elseif ( is_author() ) {
        	$layout = get_theme_mod( 'author_archive_layout' );
        } elseif ( is_category() ) {
        	$layout = get_theme_mod( 'category_archive_layout' );
        } elseif ( is_date() ) {
        	$layout = get_theme_mod( 'date_archive_layout' );
        } elseif ( is_post_type_archive() ) {
        	$layout = get_theme_mod( 'post_type_archive_layout' );
        } elseif ( is_tag() ) {
        	$layout = get_theme_mod( 'tag_archive_layout' );
        } elseif ( is_tax() ) {
        	$layout = get_theme_mod( 'taxonomy_archive_layout' );
        } elseif ( is_404() ) {
        	$layout = get_theme_mod( '404_layout' );
        } elseif ( is_search() ) {
        	$layout = get_theme_mod( 'search_layout' );
        } elseif ( is_single() && ! is_attachment() && ! is_post_type_hierarchical( $post->post_type ) ) {
        	$layout = get_theme_mod( 'single_' . $post->type . '_layout' );
        } elseif ( is_attachment() ) {
        	$layout = get_theme_mod( 'attachment_layout' );
        } elseif ( is_home() ) {
        	$layout = get_theme_mod( 'home_layout' );
        }
        
        /**
         * Check $layout against layouts to see if valid or not empty
         * If empty or invalid, return $default.
         */
        if ( empty( $layout ) /*|| ! array_key_exists(  )*/ ) {
            $layout = $default;
        }
        
        return sanitize_key( $layout );
    }
}