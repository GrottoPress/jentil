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
    die;
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
     * Get post types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array   $post_types     Array of post type objects
     */
    protected $post_types;

    /**
     * Archive Post types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $archive_post_types       All post types with archive
     */
    protected $archive_post_types = array();
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Template $template ) {
	    $this->template = $template;

	    $this->sticky_posts = $this->sticky_posts();
        $this->post_types = $this->post_types();
        $this->archive_post_types = $this->archive_post_types();
	}

    /**
     * Get sticky posts
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      array       Sticky posts
     */
    private function sticky_posts() {
        return array_map( 'absint', get_option( 'sticky_posts' ) );
    }

    /**
     * Post types
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      array         Post types
     */
    private function post_types() {
        return get_post_types( array(
            'public' => true,
            // 'show_ui' => true,
        ), 'objects' );
    }

    /**
     * Archive Post types
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      array         All post types with archive
     */
    private function archive_post_types() {
        $archive_post_types = array();

        if ( ! $this->post_types ) {
            return $archive_post_types;
        }

        foreach ( $this->post_types as $post_type ) {
            if ( $post_type->has_archive || 'post' == $post_type->name ) {
                $archive_post_types[] = $post_type->name;
            }
        }

        return $archive_post_types;
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

        $pagination = new MagPack\Utilities\Pagination();

        if (
        	( $this->sticky_enabled = $this->sticky_enabled() )
            && $this->sticky_posts
        	&& $pagination->current_page() == 1
            && ! $this->template->is( 'singular' )
        ) {
        	$out .= ( new MagPack\Utilities\Query\Posts( $this->sticky_query_args() ) )->run();
        }

        $out .= ( new MagPack\Utilities\Query\Posts( $this->query_args() ) )->run();

        return $out;
    }

    /**
     * Sticky posts enabled?
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      boolean         Do we have sticky posts enabled?
     */
    private function sticky_enabled() {
        return $this->mod( 'sticky_posts' );
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
			'layout' => 'stack',
			'id' => 'main-query',
			'class' => 'singular-post',

			'excerpt' => array(
				'length' => -2,
				'paginate' => 1,
				'more_text'	=> '',
			),

			'title' => array(
				'length' => -1,
				'position' => 'top',
				'tag' => 'h1',
				'link' => 0,
			),

			'after_title' => array(
				'type' => 'jentil_singular_after_title',
			),

			'wp_query' => array(
				'posts_per_page' => 1,
				'post_type' => $post->post_type,
				'p' => $post->ID,
				'ignore_sticky_posts' => 1,
			),
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
        global $wp_rewrite;

        $args = array(
        	// 'tag' => $this->mod( 'wrap_tag' ),
			'class' => $this->mod( 'wrap_class' ),
			'id' => 'main-query',
			'layout' => $this->mod( 'layout' ),
			'text_offset' 			=> $this->mod( 'text_offset' ),

			'image' => array(
				'size' => $this->mod( 'image' ),
				'align' => $this->mod( 'image_alignment' ),
			),

			'after_title' => array(
				'info' => $this->mod( 'after_title' ),
				'sep' => $this->mod( 'after_title_separator' ),
			),

			'after_content' => array(
				'info' => $this->mod( 'after_content' ),
				'sep' => $this->mod( 'after_content_separator' ),
			),

			'before_title' => array(
				'info' => $this->mod( 'before_title' ),
				'sep' => $this->mod( 'before_title_separator' ),
			),

			'excerpt' => array(
				'length' => $this->mod( 'excerpt' ),
				'paginate' => 0,
				'more_text' => $this->mod( 'more_link' ),
			),

			'pagination' => array(
				'type' => $this->mod( 'pagination' ),
				'max' => $this->mod( 'pagination_maximum' ),
                'key' => $wp_rewrite->pagination_base,
				'position' => $this->mod( 'pagination_position' ),
				'prev_text' => $this->mod( 'pagination_previous_label' ),
				'next_text' => $this->mod( 'pagination_next_label' ),
			),

			'title' => array(
				'length' => $this->mod( 'title_words' ),
				'position' => $this->mod( 'title_position' ),
				'tag' => 'h2',
				'link' => 1,
			),

			'wp_query' => array(
				'posts_per_page' => $this->mod( 'number' ),
				's' => get_search_query(),
				'post__not_in' => ( $this->sticky_enabled ? $this->sticky_posts : null ),
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
			),
		);

        if (
            ( $post_type = get_query_var( 'post_type' ) )
            || $this->template->is( 'home' )
            || $this->template->is( 'post_type_archive' )
        ) {
            $args['wp_query']['post_type'] = $post_type;
        } else {
            $args['wp_query']['post_type'] = $this->archive_post_types;
        }

		if ( $this->template->is( 'search' ) ) {
			if ( function_exists( 'is_customize_preview' ) ) { // If WP >= 4.0
				$args['wp_query']['orderby']['all_time_views'] = 'DESC';
				$args['wp_query']['orderby']['comment_count'] = 'DESC';
			} else {
				$args['wp_query']['orderby'] = 'all_time_views';
				$args['wp_query']['order'] = 'DESC';
			}
		}

		if ( ( $taxonomy = get_query_var( 'taxonomy' ) ) ) {
			$args['wp_query']['tax_query'] = array( 
				array(
					'taxonomy' 		=> $taxonomy,
					'terms' 		=> get_query_var( 'term' ),
					'field' 		=> 'slug',
				),
			);
		}

		if ( get_query_var( 'year' ) || get_query_var( 'monthnum' ) || get_query_var( 'day' ) ) {
			$args['wp_query']['date_query'] = array(
				array(
					'year' 			=> get_query_var( 'year' ),
					'month' 		=> get_query_var( 'monthnum' ),
					'day' 			=> get_query_var( 'day' ),
				),
			);
		}

		if ( ( $cat = get_query_var( 'cat' ) ) ) {
			$args['wp_query']['cat']	= $cat;
		}

		if ( ( $cat_in = get_query_var( 'category__in' ) ) ) {
			$args['wp_query']['category__in']	= $cat_in;
		}

		if ( ( $cat_not_in = get_query_var( 'category__not_in' ) ) ) {
			$args['wp_query']['category__not_in']	= $cat_not_in;
		}

		if ( ( $cat_and = get_query_var( 'category__and' ) ) ) {
			$args['wp_query']['category__and']	= $cat_and;
		}

		if ( ( $tag_id = get_query_var( 'tag_id' ) ) ) {
			$args['wp_query']['tag_id']	= $tag_id;
		}

		if ( ( $tag_in = get_query_var( 'tag__in' ) ) ) {
			$args['wp_query']['tag__in']	= $tag_in;
		}

		if ( ( $tag_not_in = get_query_var( 'tag__not_in' ) ) ) {
			$args['wp_query']['tag__not_in']	= $tag_not_in;
		}

		if ( ( $tag_and = get_query_var( 'tag__and' ) ) ) {
			$args['wp_query']['tag__and']	= $tag_and;
		}

		if ( ( $author_id = get_query_var( 'author' ) ) ) {
			$args['wp_query']['author'] = $author_id;
		}

		if ( ( $author_in = get_query_var( 'author__in' ) ) ) {
			$args['wp_query']['author__in'] = $author_in;
		}

		if ( ( $author_not_in = get_query_var( 'author__not_in' ) ) ) {
			$args['wp_query']['author__not_in'] = $author_not_in;
		}

		return $args;
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
        	// 'tag' => $this->sticky_mod( 'wrap_tag' ),
			'class' => $this->sticky_mod( 'wrap_class' ),
			'id' => 'main-query-sticky-posts',
			'layout' => $this->sticky_mod( 'layout' ),
			'text_offset' => $this->sticky_mod( 'text_offset' ),

			'image' => array(
				'size' => $this->sticky_mod( 'image' ),
				'align' => $this->sticky_mod( 'image_alignment' ),
			),

			'after_title' => array(
				'info' => $this->sticky_mod( 'after_title' ),
				'sep' => $this->sticky_mod( 'after_title_separator' ),
			),

			'after_content' => array(
				'info' => $this->sticky_mod( 'after_content' ),
				'sep' => $this->sticky_mod( 'after_content_separator' ),
			),

			'before_title' => array(
				'info' => $this->sticky_mod( 'before_title' ),
				'sep' => $this->sticky_mod( 'before_title_separator' ),
			),

			'excerpt' => array(
				'length' => $this->sticky_mod( 'excerpt' ),
				'paginate' => 0,
				'more_text' => $this->sticky_mod( 'more_link' ),
			),

			'title' => array(
				'length' => $this->sticky_mod( 'title_words' ),
				'position' => $this->sticky_mod( 'title_position' ),
				'tag' => 'h2',
				'link' => 1,
			),

			'wp_query' => array(
				'posts_per_page' 		=> -1,
				'post__in'				=> $this->sticky_posts,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,
			),
		);

        // if ( ( $post_type = get_query_var( 'post_type' ) ) ) {
            $args['wp_query']['post_type'] = get_query_var( 'post_type' );
        // }

		if ( ( $taxonomy = get_query_var( 'taxonomy' ) ) ) {
			$args['wp_query']['tax_query'] = array( 
				array(
					'taxonomy' 		=> $taxonomy,
					'terms' 		=> get_query_var( 'term_id' ),
					'field' 		=> 'term_id',
				),
			);
		}

		if ( get_query_var( 'year' ) || get_query_var( 'monthnum' ) || get_query_var( 'day' ) ) {
			$args['wp_query']['date_query'] = array(
				array(
					'year' 			=> get_query_var( 'year' ),
					'month' 		=> get_query_var( 'monthnum' ),
					'day' 			=> get_query_var( 'day' ),
				),
			);
		}

		if ( ( $cat = get_query_var( 'cat' ) ) ) {
			$args['wp_query']['cat']	= $cat;
		}

		if ( ( $cat_in = get_query_var( 'category__in' ) ) ) {
			$args['wp_query']['category__in']	= $cat_in;
		}

		if ( ( $cat_not_in = get_query_var( 'category__not_in' ) ) ) {
			$args['wp_query']['category__not_in']	= $cat_not_in;
		}

		if ( ( $cat_and = get_query_var( 'category__and' ) ) ) {
			$args['wp_query']['category__and']	= $cat_and;
		}

		if ( ( $tag_id = get_query_var( 'tag_id' ) ) ) {
			$args['wp_query']['tag_id']	= $tag_id;
		}

		if ( ( $tag_in = get_query_var( 'tag__in' ) ) ) {
			$args['wp_query']['tag__in']	= $tag_in;
		}

		if ( ( $tag_not_in = get_query_var( 'tag__not_in' ) ) ) {
			$args['wp_query']['tag__not_in']	= $tag_not_in;
		}

		if ( ( $tag_and = get_query_var( 'tag__and' ) ) ) {
			$args['wp_query']['tag__and']	= $tag_and;
		}

		if ( ( $author_id = get_query_var( 'author' ) ) ) {
			$args['wp_query']['author'] = $author_id;
		}

		if ( ( $author_in = get_query_var( 'author__in' ) ) ) {
			$args['wp_query']['author__in'] = $author_in;
		}

		if ( ( $author_not_in = get_query_var( 'author__not_in' ) ) ) {
			$args['wp_query']['author__not_in'] = $author_not_in;
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
    	if ( ! empty( $args['context'] ) ) {
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

            $mod = new Utilities\Mods\Posts( $setting, $args );

            if ( ! $mod->get( 'name' ) ) {
            	continue;
            }

            return $mod->mod();
        }

        return ( new Utilities\Mods\Posts( $setting, $args ) )->get( 'default' );
    }
}