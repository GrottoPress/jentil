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
     * Sticky posts enabled?
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var 	boolean 	$sticky_enabled 	Is sticky posts enabled?
	 */
    protected $sticky_enabled;

    /**
     * Get sticky posts
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var 	array 	$sticky_posts 	Sticky posts IDs
	 */
    protected $sticky_posts;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Template $template ) {
	    $this->template = $template;

	    $this->sticky_enabled = $this->sticky_enabled();

	    $this->sticky_posts = $this->sticky_posts();
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
        	$this->sticky_enabled && $this->sticky_posts
        	&& $page_number === 1 && ! $this->template->is( 'singular' )
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

			'id' 					=> 'main-query',
			'class' 				=> 'singular-post',

			'title_words' 			=> -1,
			'title_pos' 			=> 'top',
			'title_tag' 			=> 'h1',
			'title_link' 			=> 0,

			'after_title' 			=> 'jentil_singular_after_title',

			'posts_per_page' 		=> 1,
			'post_type' 			=> $post->post_type,
			'ignore_sticky_posts' 	=> 1,
		);
    }

    /**
     * Get sticky posts
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      array 		Sticky posts
     */
    private function sticky_posts() {
    	return array_map( 'absint', get_option( 'sticky_posts' ) );
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
        $args = array(
			'layout' 				=> $this->mod( 'layout' ),

			'img' 					=> $this->mod( 'image' ),
			'img_align' 			=> $this->mod( 'image_alignment' ),

			'after_title' 			=> $this->mod( 'after_title' ),
			'after_title_sep' 		=> $this->mod( 'after_title_separator' ),
			'after_content' 		=> $this->mod( 'after_content' ),
			'after_content_sep' 	=> $this->mod( 'after_content_separator' ),
			'before_title' 			=> $this->mod( 'before_title' ),
			'before_title_sep' 		=> $this->mod( 'before_title_separator' ),

			'excerpt' 				=> $this->mod( 'excerpt' ),
			'content_pag'			=> 0,

			'pag' 					=> $this->mod( 'pagination' ),
			'pag_max' 				=> $this->mod( 'pagination_maximum' ),
			'pag_pos' 				=> $this->mod( 'pagination_position' ),
			'pag_prev_label' 		=> $this->mod( 'pagination_previous_label' ),
			'pag_next_label' 		=> $this->mod( 'pagination_next_label' ),

			// 'wrap_tag' 				=> $this->mod( 'wrap_tag' ),
			'class' 				=> $this->mod( 'wrap_class' ),
			'id' 					=> 'main-query',

			'title_words' 			=> $this->mod( 'title_words' ),
			'title_pos' 			=> $this->mod( 'title_position' ),
			'title_tag' 			=> 'h2',
			'title_link' 			=> 1,

			'text_offset' 			=> $this->mod( 'text_offset' ),
			'more_link' 			=> $this->mod( 'more_link' ),

			'posts_per_page' 		=> $this->mod( 'number' ),
			's' 					=> get_search_query(),
			'post__not_in'			=> ( $this->sticky_enabled ? $this->sticky_posts : null ),
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
     * Sticky posts enabled?
     * 
     * @since		Jentil 0.1.0
     * @access      private
     * 
     * @return      boolean 		Do we have sticky posts enabled?
     */
    private function sticky_enabled() {
        return $this->mod( 'sticky_posts' );
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
        $args = array(
			'layout' 				=> $this->sticky_mod( 'layout' ),

			'img' 					=> $this->sticky_mod( 'image' ),
			'img_align' 			=> $this->sticky_mod( 'image_alignment' ),

			'after_title' 			=> $this->sticky_mod( 'after_title' ),
			'after_title_sep' 		=> $this->sticky_mod( 'after_title_separator' ),
			'after_content' 		=> $this->sticky_mod( 'after_content' ),
			'after_content_sep' 	=> $this->sticky_mod( 'after_content_separator' ),
			'before_title' 			=> $this->sticky_mod( 'before_title' ),
			'before_title_sep' 		=> $this->sticky_mod( 'before_title_separator' ),

			'excerpt' 				=> $this->sticky_mod( 'excerpt' ),
			'content_pag'			=> 0,

			// 'wrap_tag' 				=> $this->sticky_mod( 'wrap_tag' ),
			'class' 				=> $this->sticky_mod( 'wrap_class' ),
			'id' 					=> 'main-query-sticky-posts',

			'title_words' 			=> $this->sticky_mod( 'title_words' ),
			'title_pos' 			=> $this->sticky_mod( 'title_position' ),
			'title_tag' 			=> 'h2',
			'title_link' 			=> 1,

			'text_offset' 			=> $this->sticky_mod( 'text_offset' ),
			'more_link' 			=> $this->sticky_mod( 'more_link' ),

			'posts_per_page' 		=> -1,
			'post__in'				=> $this->sticky_posts,
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

    /**
     * Sticky posts mod
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      mixed 		Sticky posts mod
     */
    public function sticky_mod( $setting ) {
    	$args = array(
    		'context' => 'sticky',
    	);

    	if ( $this->template->is( 'home' ) ) {
    		$args['specific'] = 'post';
    	} elseif ( $this->template->is( 'post_type_archive' ) ) {
    		$args['specific'] = get_query_var( 'post_type' );
    	}

    	if ( is_array( $args['specific'] ) ) {
    		$args['specific'] = $args['specific'][0];
    	}

    	return $this->mod( $setting, $args );
    }

    /**
     * Posts mods
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      mixed 		Posts mod
     */
    public function mod( $setting, $args = array(
        'context' => '',
        'specific' => '',
        'more_specific' => '',
    ) ) {
    	if ( $args['context'] ) {
        	return ( new Utilities\Mods\Posts( $setting, $args ) )->mod();
        }

    	$template = $this->template->type();

	    foreach ( $template as $type ) {
            $args['context'] = $type;

            if ( 'post_type_archive' == $type ) {
                $args['specific'] = get_query_var( 'post_type' );
            } elseif ( 'tax' == $type ) {
                $args['specific'] = get_query_var( 'taxonomy' );
            } elseif ( 'category' == $type ) {
            	$args['specific'] = 'category';
            } elseif ( 'tag' == $type ) {
            	$args['specific'] = 'post_tag';
            }

            if ( is_array( $args['specific'] ) ) {
                $args['specific'] = $args['specific'][0];
            }

            if ( is_array( $args['more_specific'] ) ) {
                $args['more_specific'] = $args['more_specific'][0];
            }

            if ( ( $mod = ( new Utilities\Mods\Posts( $setting, $args ) )->mod() ) ) {
            	return $mod;
            }
        }

        return ( new Utilities\Mods\Posts( $setting, $args ) )->get( 'default' );
    }
}