<?php

/**
 * Template posts
 * 
 * Returns queried posts based on template
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/utilities/template
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Content
 * 
 * Template content
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/utilities/template
 * @since			Jentil 0.1.0
 */
final class Posts extends MagPack\Utilities\Wizard {
	/**
     * Template
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var 	\GrottoPress\Jentil\Utilities\Template\Template 	$template 	Template
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
     * Get Posts
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      string 		Marked up posts
     */
    public function query() {
        $out = '';

        $page_number = isset( $_GET['main-query_pag'] ) ? absint( $_GET['main-query_pag'] ) : 1;

        if (
        	$this->has_sticky()
        	&& $page_number === 1
        	&& ! $this->template->is( 'singular' )
        ) {
        	$out .= ( new MagPack\Utilities\Query\Posts( $this->sticky_query_args() ) )->run();
        }

        $out .= ( new MagPack\Utilities\Query\Posts( $this->query_args() ) )->run();

        return $out;
    }

	/**
     * Get Posts Query Args
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      array 		Args to pass to \GrottoPress\MagPack\Utilities\Query\Posts
     */
    private function query_args() {
        if ( $this->template->is( 'singular' ) ) {
        	return $this->singular_query_args();
        }

        return $this->archives_query_args();
    }

    /**
     * Get Posts Query Args
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      array 		Args to pass to \GrottoPress\MagPack\Utilities\Query\Posts
     */
    private function singular_query_args() {
        global $post;

		return array(
			'layout' 				=> 'stack',
			'more_link' 			=> '',

			'excerpt' 				=> 'content',
			'content_pag' 			=> 1,

			'p' 					=> $post->ID,

			'id' 					=> '', 
			'class' 				=> 'singular-post',

			'title_words' 			=> -1,
			'title_pos' 			=> 'top',
			'title_tag' 			=> 'h1',
			'title_link' 			=> 0,

			'after_title' 			=> 'jentil_single_post_after_title',

			'posts_per_page' 		=> 1,
			'post_type' 			=> $post->post_type,
			'ignore_sticky_posts' 	=> 1,
		);
    }

    /**
     * Archives Posts Query Args
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      array 		Args to pass to \GrottoPress\MagPack\Utilities\Query\Posts
     */
    private function archives_query_args() {
        $content = $this->template->get( 'content' );

        $args = array(
			'layout' 				=> $content->mod( 'layout', 'stack' ),

			'img' 					=> $content->mod( 'image', 'mini-thumb' ),
			'img_align' 			=> $content->mod( 'image_alignment', 'left' ),

			'after_title' 			=> $content->mod( 'after_title', 'published_date, comments_link' ),
			'after_title_sep' 		=> $content->mod( 'after_title_separator', ' | ' ),
			'after_content' 		=> $content->mod( 'after_content', 'category, post_tag' ),
			'after_content_sep' 	=> $content->mod( 'after_content_separator', ' | ' ),
			'before_title' 			=> $content->mod( 'before_title' ),
			'before_title_sep' 		=> $content->mod( 'before_title_separator', ' | ' ),

			'excerpt' 				=> $content->mod( 'excerpt', '300' ),
			'content_pag'			=> 1,

			'pag' 					=> $content->mod( 'pagination' ),
			'pag_max' 				=> $content->mod( 'pagination_maximum' ),
			'pag_pos' 				=> $content->mod( 'pagination_position', 'bottom' ),
			'pag_prev_label' 		=> $content->mod( 'pagination_previous_label', __( '&larr; Previous', 'jentil' ) ),
			'pag_next_label' 		=> $content->mod( 'pagination_next_label', __( 'Next &rarr;', 'jentil' ) ),

			'wrap_tag' 				=> $content->mod( 'wrap_tag', 'div' ),
			'class' 				=> $content->mod( 'wrap_class', 'archive-posts big' ),
			'id' 					=> 'main-query',

			'title_words' 			=> $content->mod( 'title_words', -1 ),
			'title_pos' 			=> $content->mod( 'title_position', 'side' ),
			'title_tag' 			=> 'h2',
			'title_link' 			=> 1,

			'text_offset' 			=> $content->mod( 'text_offset' ),
			'more_link' 			=> $content->mod( 'more_link', esc_html__( 'read more', 'jentil' ) ),

			'posts_per_page' 		=> $content->mod( 'number', get_option( 'posts_per_page' ) ),
			's' 					=> get_search_query(),
			'post__not_in'			=> ( $this->has_sticky() ? get_option( 'sticky_posts' ) : null ),
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
		);

		if ( $this->template->is( 'search' ) ) {
			if ( version_compare( get_bloginfo( 'version' ), '4.0', '>=' ) ) {
				$args['orderby']['all_time_views'] = 'DESC';
				$args['orderby']['comment_count'] = 'DESC';
			} else {
				$args['orderby'] = 'all_time_views';
				$args['order'] = 'DESC';
			}

			$args['img'] = $content->mod( 'image', 'micro-thumb' );
			$args['title_position'] = $content->mod( 'title_position', 'top' );
			$args['after_title'] = $content->mod( 'after_title', 'post_type, comments_link' );
		}

		if ( ( $taxonomy = get_query_var( 'taxonomy' ) ) ) {
			$args['tax_query'] = array( 
				array(
					'taxonomy' 		=> $taxonomy,
					'terms' 		=> get_query_var( 'term_id' ),
					'field' 		=> 'term_id',
				),
			);
		}

		if ( get_query_var( 'year' ) || get_query_var( 'monthnum' ) || get_query_var( 'day' ) ) {
			$args['date_query'] = array(
				array(
					'year' 			=> get_query_var( 'year' ),
					'month' 		=> get_query_var( 'monthnum' ),
					'day' 			=> get_query_var( 'day' ),
				),
			);
		}

		// if ( ( $post_type = get_query_var( 'post_type' ) ) ) {
			$args['post_type'] = get_query_var( 'post_type' );
		// }

		if ( ( $cat = get_query_var( 'cat' ) ) ) {
			$args['cat']	= $cat;
		}

		if ( ( $cat_in = get_query_var( 'category__in' ) ) ) {
			$args['category__in']	= $cat_in;
		}

		if ( ( $cat_not_in = get_query_var( 'category__not_in' ) ) ) {
			$args['category__not_in']	= $cat_not_in;
		}

		if ( ( $cat_and = get_query_var( 'category__and' ) ) ) {
			$args['category__and']	= $cat_and;
		}

		if ( ( $tag_id = get_query_var( 'tag_id' ) ) ) {
			$args['tag_id']	= $tag_id;
		}

		if ( ( $tag_in = get_query_var( 'tag__in' ) ) ) {
			$args['tag__in']	= $tag_in;
		}

		if ( ( $tag_not_in = get_query_var( 'tag__not_in' ) ) ) {
			$args['tag__not_in']	= $tag_not_in;
		}

		if ( ( $tag_and = get_query_var( 'tag__and' ) ) ) {
			$args['tag__and']	= $tag_and;
		}

		if ( ( $author_id = get_query_var( 'author' ) ) ) {
			$args['author'] = $author_id;
		}

		if ( ( $author_in = get_query_var( 'author__in' ) ) ) {
			$args['author__in'] = $author_in;
		}

		if ( ( $author_not_in = get_query_var( 'author__not_in' ) ) ) {
			$args['author__not_in'] = $author_not_in;
		}

		return $args;
    }

    /**
     * Has sticky posts?
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      boolean 		Do we have sticky posts enabled?
     */
    private function has_sticky() {
        return ( $this->template->get( 'content' )->mod( 'sticky_posts' ) );
    }

    /**
     * Sticky Posts Query Args
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      array 		Args to pass to \GrottoPress\MagPack\Utilities\Query\Posts
     */
    private function sticky_query_args() {
        $sticky = new Utilities\Sticky();

		$args = array(
			'layout' 				=> $sticky->mod( 'layout', 'stack' ),

			'img' 					=> $sticky->mod( 'image', 'mini-thumb' ),
			'img_align' 			=> $sticky->mod( 'image_alignment', 'left' ),

			'after_title' 			=> $sticky->mod( 'after_title', 'published_date, comments_link' ),
			'after_title_sep' 		=> $sticky->mod( 'after_title_separator', ' | ' ),
			'after_content' 		=> $sticky->mod( 'after_content', 'category, post_tag' ),
			'after_content_sep' 	=> $sticky->mod( 'after_content_separator', ' | ' ),
			'before_title' 			=> $sticky->mod( 'before_title' ),
			'before_title_sep' 		=> $sticky->mod( 'before_title_separator', ' | ' ),

			'excerpt' 				=> $sticky->mod( 'excerpt', '300' ),
			'content_pag'			=> 1,

			'pag' 					=> $sticky->mod( 'pagination' ),
			'pag_max' 				=> $sticky->mod( 'pagination_maximum' ),
			'pag_pos' 				=> $sticky->mod( 'pagination_position', 'none' ),
			'pag_prev_label' 		=> $sticky->mod( 'pagination_previous_label', __( '&larr; Previous', 'jentil' ) ),
			'pag_next_label' 		=> $sticky->mod( 'pagination_next_label', __( 'Next &rarr;', 'jentil' ) ),

			'wrap_tag' 				=> $sticky->mod( 'wrap_tag', 'div' ),
			'class' 				=> $sticky->mod( 'wrap_class', 'sticky-posts big' ),
			'id' 					=> 'main-query-sticky-posts',

			'title_words' 			=> $sticky->mod( 'title_words', -1 ),
			'title_pos' 			=> $sticky->mod( 'title_position', 'side' ),
			'title_tag' 			=> 'h2',
			'title_link' 			=> 1,

			'text_offset' 			=> $sticky->mod( 'text_offset' ),
			'more_link' 			=> $sticky->mod( 'more_link', esc_html__( 'read more', 'jentil' ) ),

			'posts_per_page' 		=> $sticky->mod( 'number', 3 ),
			'post__in'				=> get_option( 'sticky_posts' ),
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
		);

		if ( ( $taxonomy = get_query_var( 'taxonomy' ) ) ) {
			$args['tax_query'] = array( 
				array(
					'taxonomy' 		=> $taxonomy,
					'terms' 		=> get_query_var( 'term_id' ),
					'field' 		=> 'term_id',
				),
			);
		}

		if ( get_query_var( 'year' ) || get_query_var( 'monthnum' ) || get_query_var( 'day' ) ) {
			$args['date_query'] = array(
				array(
					'year' 			=> get_query_var( 'year' ),
					'month' 		=> get_query_var( 'monthnum' ),
					'day' 			=> get_query_var( 'day' ),
				),
			);
		}

		// if ( ( $post_type = get_query_var( 'post_type' ) ) ) {
			$args['post_type'] = get_query_var( 'post_type' );
		// }

		if ( ( $cat = get_query_var( 'cat' ) ) ) {
			$args['cat']	= $cat;
		}

		if ( ( $cat_in = get_query_var( 'category__in' ) ) ) {
			$args['category__in']	= $cat_in;
		}

		if ( ( $cat_not_in = get_query_var( 'category__not_in' ) ) ) {
			$args['category__not_in']	= $cat_not_in;
		}

		if ( ( $cat_and = get_query_var( 'category__and' ) ) ) {
			$args['category__and']	= $cat_and;
		}

		if ( ( $tag_id = get_query_var( 'tag_id' ) ) ) {
			$args['tag_id']	= $tag_id;
		}

		if ( ( $tag_in = get_query_var( 'tag__in' ) ) ) {
			$args['tag__in']	= $tag_in;
		}

		if ( ( $tag_not_in = get_query_var( 'tag__not_in' ) ) ) {
			$args['tag__not_in']	= $tag_not_in;
		}

		if ( ( $tag_and = get_query_var( 'tag__and' ) ) ) {
			$args['tag__and']	= $tag_and;
		}

		if ( ( $author_id = get_query_var( 'author' ) ) ) {
			$args['author'] = $author_id;
		}

		if ( ( $author_in = get_query_var( 'author__in' ) ) ) {
			$args['author__in'] = $author_in;
		}

		if ( ( $author_not_in = get_query_var( 'author__not_in' ) ) ) {
			$args['author__not_in'] = $author_not_in;
		}

		return $args;
    }
}