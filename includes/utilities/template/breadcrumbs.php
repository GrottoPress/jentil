<?php

/**
 * Breadcrumbs
 *
 * @link       	https://jentil.grottopress.com
 * @since      	Jentil 0.1.0
 *
 * @package         jentil
 * @subpackage      jentil/includes/utilities
 */
namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Breadcrumbs
 *
 * The breadcrumbs trail.
 *
 * @author     	N Atta Kusi Adusei
 */
final class Breadcrumbs {
    /**
	 * Import traits
	 *
	 * @since 		Jentil 0.1.0
	 */
	use MagPack\Utilities\Wizard;

	/**
	 * Home label
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var      string  			$home_label    		Label for the home link
	 */
	protected $home_label;
	
	/**
	 * Delimiter
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var      string  			$delimiter    		Links delimiter
	 */
	protected $delimiter;
	
	/**
	 * Before
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var      string  			$before    		    Text to prepend to breadcrumbs
	 */
	protected $before;
	
	/**
	 * After
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var      string  			$after    		    Text to append to breadcrumbs
	 */
	protected $after;
	
	/**
	 * Breadcrumb links
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var      array  			$links    	    The breadcrumb links.
	 */
	protected $links;

	/**
	 * Template
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var 	\GrottoPress\Jentil\Utilities\Template\Template 	$template    Template instance.
	 */
	protected $template;

	/**
	 * Pagination
	 *
	 * @since    Jentil 0.1.0
	 * @access   protected
	 * 
	 * @var 	\GrottoPress\Jentil\Utilities\Pagination\Pagination  	$pagination    Pagination.
	 */
	protected $pagination;
    
    /**
	 * Constructor
	 *
	 * @var 		\GrottoPress\Jentil\Utilities\Template\Template 	$template 	Template object
	 * @var 		array 		$args 		Breadcrumb args supplied as associative array
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Template $template, $args = [] ) {
	    $this->template = $template;
	    $this->pagination = new MagPack\Utilities\Pagination();

	    $this->home_label = empty( $args['home_label'] ) ? esc_html__( 'Home', 'jentil' ) : sanitize_text_field( $args['home_label'] );
	    $this->delimiter = empty( $args['delimiter'] ) ? $this->delimiter() : esc_attr( $args['delimiter'] );
	    $this->after = empty( $args['after'] ) ? '' : sanitize_text_field( $args['after'] );
	    $this->before = empty( $args['before'] ) ? '' : sanitize_text_field( $args['before'] );
	    
	    $this->links = [];
	}
	
	/**
	 * Delimiter
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function delimiter() {
	    return ( is_rtl() ? '/' : '\\' );
	}
	
	/**
	 * The breadcrumbs trail
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return		string		The breadcrumbs trail.
	 */
	public function trail() {
		// if ( $this->template->is( 'front_page' ) && ! $this->pagination->is_paged() ) {
		// 	return '';
		// }
	    
	    $this->add_links();
	    
	    $trail = '<nav class="breadcrumbs" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
	    
		if ( is_rtl() ) {
			$trail .= $this->trail_rtl();
		} else {
			$trail .= $this->trail_ltr();
		}
		
		$trail .= '</nav>';
		
		return $trail;
	}
	
	/**
	 * The breadcrumbs trail - RTL
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @return		string		The breadcrumbs trail for right-to-left languages.
	 */
	private function trail_rtl() {
		$trail = '';
		
		if ( ! empty( $this->after ) ) {
			$trail .= '<span class="after">' . $this->after . '</span> ';
		}
		
		$trail .= join( ' <span class="sep delimiter">' . $this->delimiter . '</span> ', array_reverse( $this->links ) );
		
		if ( ! empty( $this->before ) ) {
			$trail .= ' <span class="before">' . $this->before . '</span>';
		}
		
		return $trail;
	}
	
	/**
	 * The breadcrumbs trail - LTR
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @return		string		The breadcrumbs trail for left-to-right languages.
	 */
	private function trail_ltr() {
		$trail = '';
		
		if ( ! empty( $this->before ) ) {
			$trail .= '<span class="before">' . $this->before . '</span> ';
		}
		
		$trail .= join( ' <span class="sep delimiter">' . $this->delimiter . '</span> ', $this->links );
		
		if ( ! empty( $this->after ) ) {
			$trail .= ' <span class="after">' . $this->after . '</span>';
		}
		
		return $trail;
	}
	
	/**
	 * Add breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_links() {
	    if ( ! $this->template->is( 'front_page' ) ) {
	    	$this->add_home_link();
	    }

	    $this_template = $this->template->type();
	    
	    foreach ( $this_template as $template ) {
	    	$add_links = 'add_' . $template . '_links';
    		
			if ( is_callable( [ $this, $add_links ] ) ) {
				$this->$add_links();

				break;
			}
	    }
	    
	    if ( $this->pagination->is_paged() && ! $this->template->is( '404' ) ) {
	    	$this->add_page_number_link();
	    }

	    /**
		 * Filter the breadcrumb links.
		 * 
		 * @var 	array 		$this->links 		Breadcrub links for current template.
		 * @var 	\GrottoPress\Jentil\Utilities\Template\Breadcrumbs 	$this 	Breadcrumbs
		 *
		 * @filter 		jentil_breadcrumbs_links
		 *
		 * @since       Jentil 0.1.0
		 */
	    $this->links = apply_filters( 'jentil_breadcrumbs_links', $this->links, $this );
	}

	/**
	 * Front page breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_front_page_links() {
	    $this->links[] = $this->current_link( $this->home_label, home_url( '/' ) );
	}
	
	/**
	 * Home breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_home_links() {
	    $home = get_option( 'page_for_posts' );
	    $title = get_the_title( $home );
	    $url = get_permalink( $home );
	    
	    $this->links[] = $this->current_link( $title, $url );
	}
	
	/**
	 * Category archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_category_links() {
	    $cat_id = absint( get_query_var( 'cat' ) );
		$cat = get_category( $cat_id );
		$cat_parent_id = absint( $cat->parent );
		
		$cat_links = [];
		
		if ( $cat_parent_id ) {
			while ( $cat_parent_id ) {
				$cat_parent = get_category( $cat_parent_id );
				$cat_links[] = $this->make_link( $cat_parent->name, get_category_link( absint( $cat_parent->term_id ) ) );
				$cat_parent_id = absint( $cat_parent->parent );
			}
			
			$this->links = array_merge( $this->links, array_reverse( $cat_links ) );
		}
		
		$this->links[] = $this->current_link( single_cat_title( '', false ), get_category_link( $cat_id ) );
	}
	
	/**
	 * Day archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_day_links() {
	    $year = get_query_var( 'year' );
		$month = get_query_var( 'monthnum' );
		$day = get_query_var( 'day' );

		$timestamp = strtotime( $year . '-' . $month . '-' . $day );
		
	    $this->links[] = $this->make_link( date( 'Y', $timestamp ), get_year_link( $year ) );
		$this->links[] = $this->make_link( date( 'F Y', $timestamp ), get_month_link( $year, $month ) );
		$this->links[] = $this->current_link( date( get_option( 'date_format' ), $timestamp ),
			get_day_link( $year, $month, $day ) );
	}
	
	/**
	 * Month archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_month_links() {
	    $year = get_query_var( 'year' );
		$month = get_query_var( 'monthnum' );

		$timestamp = strtotime( $year . '-' . $month );
		
		$this->links[] = $this->make_link( date( 'Y', $timestamp ), get_year_link( $year ) );
		$this->links[] = $this->current_link( date( 'F Y', $timestamp ),
			get_month_link( $year, $month ) );
	}
	
	/**
	 * Year archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_year_links() {
	    $year = get_query_var( 'year' );
	    
	    $this->links[] = $this->current_link( $year, get_year_link( $year ) );
	}
	
	/**
	 * Search archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_search_links() {
	    $this->links[] = $this->current_link( get_search_query(), get_search_link( get_search_query() ) );
	}
	
	/**
	 * Tag archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_tag_links() {
	    $tag_id = get_query_var( 'tag_id' );
		$tag_label = single_tag_title( '', false );
		
		$this->links[] = $this->current_link( $tag_label, get_tag_link( $tag_id ) );
	}
	
	/**
	 * Author archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_author_links() {
	    $author_id = get_query_var( 'author' );
		$author_name = get_the_author_meta( 'display_name', $author_id );
		
		$this->links[] = $this->current_link( $author_name, get_author_posts_url( $author_id ) );
	}
	
	/**
	 * 404 breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_404_links() {
	    $this->links[] = $this->make_link( esc_html__( 'Error 404', 'jentil' ) );
	}
	
	/**
	 * Post type archive breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_post_type_archive_links() {
	    $post_type = get_query_var( 'post_type' );
		$post_type_link = get_post_type_archive_link( $post_type );
		$post_type_label = post_type_archive_title( '', false );
		
		$this->links[] = $this->current_link( $post_type_label, get_post_type_archive_link( $post_type ) );
	}
	
	/**
	 * Taxonomy breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_tax_links() {
	    $tax_slug = get_query_var( 'taxonomy' );
		$term_slug = get_query_var( 'term' );
		$term = get_term_by( 'slug', $term_slug, $tax_slug );
		$term_id = absint( $term->term_id );
		$term_parent_id = absint( $term->parent );
		
		$tax_links = [];
		
		if ( $term_parent_id ) {
			while ( $term_parent_id ) {
				$term_parent = get_term_by( 'id', $term_parent_id, $term->taxonomy );
				$tax_links[] = $this->make_link( $term_parent->name, get_term_link( absint( $term_parent->term_id ) ) );
				$term_parent_id = absint( $term_parent->parent );
			}
			
			$this->links = array_merge( $this->links, array_reverse( $tax_links ) );
		}
		
		$this->links[] = $this->current_link( single_term_title( '', false ), get_term_link( $term_id, $tax_slug ) );
	}
	
	/**
	 * Single page/post/attachment breadcrumb links
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function add_singular_links() {
	    global $post;

	    $use_post = $post->post_parent ? get_post( $post->post_parent ) : $post;

	    if ( ! is_post_type_hierarchical( get_post_type( $use_post ) ) ) {
			$taxonomies = $this->get_hierarchical_taxonomies( $use_post->post_type );
			
			$taxonomy_selected = '';
			$term_selected = 0;
			
			if ( $taxonomies ) {
				foreach ( $taxonomies as $taxonomy => $terms ) {
					$taxonomy_selected = $taxonomy;
					$post_terms = wp_get_post_terms( $use_post->ID, $taxonomy_selected );
					
					if ( $post_terms && ! is_wp_error( $post_terms ) ) {
						foreach ( $post_terms as $term_object ) {
							$term_selected = absint( $term_object->term_id );
							break 2; /** Get the first term of the first taxonomy and break */
						}
					}
				}
				
				$term_id = $term_selected;
				$single_links = [];
				
				while ( $term_id ) {
					$term = get_term_by( 'id', $term_id, $taxonomy_selected );
					$single_links[] = $this->make_link( $term->name, get_term_link( absint( $term->term_id ), $term->taxonomy ) );
					$term_id = absint( $term->parent );
				}
				
				/**
				 * Allow plugins to override breadcrumb links for single posts.
				 * Useful for the Taxonomy Pages addon to replace links with mapped page links
				 *
				 * @deprecated 		0.1.0 		Use `jentil_breadcrumbs_links` filter instead
				 */
				// $single_links = (array) apply_filters( 'jentil_breadcrumbs_singular_tax_links',
				// 	$single_links,
				// 	$term_selected,
				// 	$taxonomy_selected );
				
				$this->links = array_merge( $this->links, array_reverse( $single_links ) );
			} else /*if ( ! $post->post_parent )*/ {
				if ( // NB: 'post' archive is the same as frontpage unless page_for_posts is set
					'post' != $post->post_type
					|| ( $page_for_posts = get_option( 'page_for_posts' ) )
				) {
			    	$post_type_object = get_post_type_object( $post->post_type );

			    	$label = ( 'post' == $post->post_type && $page_for_posts
			    		? get_the_title( $page_for_posts )
			    		: $post_type_object->labels->name );

			    	if ( 'post' == $post->post_type || $post_type_object->has_archive ) {
			    		$this->links[] = $this->make_link( $label, get_post_type_archive_link( $post->post_type ) );
			    	}
			    }
			}
		}
		
		if ( $post->post_parent ) {
			$parent_id = $post->post_parent;
			
			$single_links = [];
			
			while ( $parent_id ) {
				$parent = get_post( $parent_id );
				$single_links[] = $this->make_link( get_the_title( $parent->ID ), get_permalink( $parent->ID ) );
				$parent_id = $parent->post_parent;
			}
			
			$this->links = array_merge( $this->links, array_reverse( $single_links ) );
		}
		
		$this->links[] = $this->current_link(
			get_the_title( $post->ID ),
			get_permalink( $post->ID )
		);
	}
	
	/**
	 * Get all hierarchical taxonomies.
	 *
	 * @var 		array/string 		A string or indexed array of post types
	 *
	 * @since    	Jentil 0.1.0
	 * @access   	public
	 *
	 * @return 		array 				An associative array of hierarchical taxonomies and their respective terms.
	 */
	public function get_hierarchical_taxonomies( $post_types = '' ) {
		if ( ! $post_types ) {
			$post_types = get_post_types( [ 'public' => true ], 'names' );
		} else {
			$post_types = is_array( $post_types ) ? $post_types : explode( ',', $post_types );
		}
		
		$taxonomies = [];

		if ( ! $post_types ) {
			return $taxonomies;
		}
		
		foreach ( $post_types as $post_type ) {
			$taxes = get_object_taxonomies( $post_type, 'objects' );
			
			if ( ! $taxes ) {
				continue;
			}

			foreach ( $taxes as $tax_slug => $tax_object ) {
				if ( ! is_taxonomy_hierarchical( $tax_slug ) ) {
					continue;
				}
				
				$terms = get_terms( $tax_object->name, [ 'hide_empty' => false ] );
				
				if ( ! $terms || is_wp_error( $terms ) ) {
					continue;
				}
				
				foreach ( $terms as $term_object ) {
					$taxonomies[ $tax_slug ][] = absint( $term_object->term_id );
				}
			}
		}
		
		return $taxonomies;
	}
	
	/**
	 * Home link
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function add_home_link() {
	   $this->links[] = $this->make_link( $this->home_label, home_url( '/' ) );
	}
	
	/**
	 * Page number link
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function add_page_number_link() {
	    $this->links[] = $this->make_link( $this->pagination->get_current_page( '', '' ) );
	}
	
	/**
	 * Current link
	 * 
	 * @var         string      $url                URL
	 * @var         string      $title              Link title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return		string			Current page link
	 */
	public function current_link( $title = '', $url = '' ) {
	    if ( $this->pagination->is_paged() ) {
			return $this->make_link( $title, $url );
		} else {
			return $this->make_link( $title );
		}
	}
	
	/**
	 * Make a link
	 * 
	 * @var         string      $url                URL
	 * @var         string      $title              Link title
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function make_link( $title = '', $url = '' ) {
	    if ( ! $title ) {
	        return '';
	    }
	    
	    $link = '';
	    
	    if ( $url ) {
	        $link .= '<a href="' . esc_url( $url ) . '" itemprop="url">';
        }
		
		$link .= '<span itemprop="itemListElement">' . sanitize_text_field( $title ) . '</span>';
		
		if ( $url ) {
		    $link .= '</a>';
		}
		
		return $link;
	}
}