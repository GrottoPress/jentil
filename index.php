<?php

/**
 * Main template
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

use GrottoPress\Jentil;
use GrottoPress\MagPack;

$template = new Jentil\Utilities\Template\Template();
$template_content = $template->get( 'content' );
$template_title = $template->get( 'title' );
$sticky_posts = $template_content->get_mod( 'sticky_posts', 1 );

$posts_per_page = get_option( 'posts_per_page' );
$pag = isset( $_GET['pag'] ) ? absint( $_GET['pag'] ) : 1;

/**
 * The query
 * 
 * @since		Jentil 0.1.0
 */

$query = '';

if ( $template->is( 'singular' ) ) {
	global $post;

	$args = array(
		'layout' 			=> 'stack',
		'more_link' 		=> '',

		'excerpt' 			=> 'content',
		'content_pag' 		=> 1,

		'p' 				=> $post->ID,

		'id' 				=> '', 
		'class' 			=> 'singular-post',

		'title_words' 		=> -1,
		'title_pos' 		=> 'top',
		'title_tag' 		=> 'h1',
		'title_link' 		=> 0,

		'after_title' 		=> 'jentil_single_post_after_title',

		'posts_per_page' 	=> 1,
		'post_type' 		=> $post->post_type,
		'ignore_sticky_posts' 	=> 1,
	);

	$query .= ( new MagPack\Utilities\Query( $args ) )->run();
} else {
	if ( $sticky_posts && $pag === 1 ) {
		$sticky = new Jentil\Utilities\Sticky();

		$sticky_args = array(
			'layout' 				=> $sticky->get_mod( 'layout', 'stack' ),

			'img' 					=> $sticky->get_mod( 'image', 'mini-thumb' ),
			'img_align' 			=> $sticky->get_mod( 'image_alignment', 'left' ),

			'after_title' 			=> $sticky->get_mod( 'after_title', 'published_date, comments_link' ),
			'after_title_sep' 		=> $sticky->get_mod( 'after_title_separator', ' | ' ),
			'after_content' 		=> $sticky->get_mod( 'after_content', 'category, post_tag' ),
			'after_content_sep' 	=> $sticky->get_mod( 'after_content_separator', ' | ' ),
			'before_title' 			=> $sticky->get_mod( 'before_title' ),
			'before_title_sep' 		=> $sticky->get_mod( 'before_title_separator', ' | ' ),

			'excerpt' 				=> $sticky->get_mod( 'excerpt', '300' ),
			'content_pag'			=> 1,

			'pag' 					=> $pag,
			'pag_pos' 				=> $sticky->get_mod( 'pagination_position', 'none' ),
			'pag_prev_label' 		=> $sticky->get_mod( 'pagination_previous_label', __( '&larr; Previous', 'jentil' ) ),
			'pag_next_label' 		=> $sticky->get_mod( 'pagination_next_label', __( 'Next &rarr;', 'jentil' ) ),

			'class' 				=> $sticky->get_mod( 'class', 'sticky-posts big' ),
			'id' 					=> 'sticky-posts',

			'title_words' 			=> $sticky->get_mod( 'title_words', -1 ),
			'title_pos' 			=> $sticky->get_mod( 'title_position', 'side' ),
			'title_tag' 			=> 'h2',
			'title_link' 			=> 1,

			'text_offset' 			=> $sticky->get_mod( 'text_offset' ),
			'more_link' 			=> $sticky->get_mod( 'more_link', esc_html__( 'read more', 'jentil' ) ),

			'posts_per_page' 		=> $sticky->get_mod( 'number', 3 ),
			'post__in'				=> get_option( 'sticky_posts' ),
			'ignore_sticky_posts' 	=> 1,
		);

		if ( ( $taxonomy = get_query_var( 'taxonomy' ) ) ) {
			$sticky_args['tax_query'] = array( 
				array(
					'taxonomy' 		=> $taxonomy,
					'terms' 		=> get_query_var( 'term_id' ),
					'field' 		=> 'term_id',
				),
			);
		}

		if ( get_query_var( 'year' ) || get_query_var( 'monthnum' ) || get_query_var( 'day' ) ) {
			$sticky_args['date_query'] = array(
				array(
					'year' 			=> get_query_var( 'year' ),
					'month' 		=> get_query_var( 'monthnum' ),
					'day' 			=> get_query_var( 'day' ),
				),
			);
		}

		if ( ( $post_type = get_query_var( 'post_type' ) ) ) {
			$sticky_args['post_type'] = $post_type;
		}

		if ( ( $cat = get_query_var( 'cat' ) ) ) {
			$sticky_args['cat']	= $cat;
		}

		if ( ( $cat_in = get_query_var( 'category__in' ) ) ) {
			$sticky_args['category__in']	= $cat_in;
		}

		if ( ( $cat_not_in = get_query_var( 'category__not_in' ) ) ) {
			$sticky_args['category__not_in']	= $cat_not_in;
		}

		if ( ( $cat_and = get_query_var( 'category__and' ) ) ) {
			$sticky_args['category__and']	= $cat_and;
		}

		if ( ( $tag_id = get_query_var( 'tag_id' ) ) ) {
			$sticky_args['tag_id']	= $tag_id;
		}

		if ( ( $tag_in = get_query_var( 'tag__in' ) ) ) {
			$sticky_args['tag__in']	= $tag_in;
		}

		if ( ( $tag_not_in = get_query_var( 'tag__not_in' ) ) ) {
			$sticky_args['tag__not_in']	= $tag_not_in;
		}

		if ( ( $tag_and = get_query_var( 'tag__and' ) ) ) {
			$sticky_args['tag__and']	= $tag_and;
		}

		if ( ( $author_id = get_query_var( 'author' ) ) ) {
			$sticky_args['author'] = $author_id;
		}

		if ( ( $author_in = get_query_var( 'author__in' ) ) ) {
			$sticky_args['author__in'] = $author_in;
		}

		if ( ( $author_not_in = get_query_var( 'author__not_in' ) ) ) {
			$sticky_args['author__not_in'] = $author_not_in;
		}

		$query .= ( new MagPack\Utilities\Query( $sticky_args ) )->run();
	}

	$args = array(
		'layout' 				=> $template_content->get_mod( 'layout', 'stack' ),

		'img' 					=> $template_content->get_mod( 'image', 'mini-thumb' ),
		'img_align' 			=> $template_content->get_mod( 'image_alignment', 'left' ),

		'after_title' 			=> $template_content->get_mod( 'after_title', 'published_date, comments_link' ),
		'after_title_sep' 		=> $template_content->get_mod( 'after_title_separator', ' | ' ),
		'after_content' 		=> $template_content->get_mod( 'after_content', 'category, post_tag' ),
		'after_content_sep' 	=> $template_content->get_mod( 'after_content_separator', ' | ' ),
		'before_title' 			=> $template_content->get_mod( 'before_title' ),
		'before_title_sep' 		=> $template_content->get_mod( 'before_title_separator', ' | ' ),

		'excerpt' 				=> $template_content->get_mod( 'excerpt', '300' ),
		'content_pag'			=> 1,

		// 'pag' 					=> '',
		'pag_pos' 				=> $template_content->get_mod( 'pagination_position', 'bottom' ),
		'pag_prev_label' 		=> $template_content->get_mod( 'pagination_previous_label', __( '&larr; Previous', 'jentil' ) ),
		'pag_next_label' 		=> $template_content->get_mod( 'pagination_next_label', __( 'Next &rarr;', 'jentil' ) ),

		'class' 				=> $template_content->get_mod( 'class', 'archive-posts big' ),
		// 'id' 					=> '',

		'title_words' 			=> $template_content->get_mod( 'title_words', -1 ),
		'title_pos' 			=> $template_content->get_mod( 'title_position', 'side' ),
		'title_tag' 			=> 'h2',
		'title_link' 			=> 1,

		'text_offset' 			=> $template_content->get_mod( 'text_offset' ),
		'more_link' 			=> $template_content->get_mod( 'more_link', esc_html__( 'read more', 'jentil' ) ),

		'posts_per_page' 		=> $template_content->get_mod( 'number', $posts_per_page ),
		's' 					=> get_search_query(),
		'post__not_in'			=> ( $sticky_posts ? get_option( 'sticky_posts' ) : null ),
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

	if ( ( $post_type = get_query_var( 'post_type' ) ) ) {
		$args['post_type'] = $post_type;
	}

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

	$query .= ( new MagPack\Utilities\Query( $args ) )->run();	
}

/**
 * Begin template rendering
 * 
 * @since		Jentil 0.1.0
 */

get_header();

?>

<div id="container">
	<main id="content" class="site-content">
		
		<?php
		/**
		 * Do action before title
		 * 
		 * @action		jentil_before_title
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_before_title' );
		
		if ( ! $template->is( 'singular' ) ) { ?>
		
			<header>
				<h1 class="page-title entry-title" itemprop="name">

					<?php echo $template_title->get_it(); ?>
					
				</h1>
				
				<?php
				/**
				 * Do action after title
				 * 
				 * @action		jentil_after_title
				 *
				 * @since       Jentil 0.1.0
				 */
				do_action( 'jentil_after_title' );
		
				if ( $template->is( 'category' ) ) {
					$category_description = category_description();
					
					if ( $category_description ) { ?>
					
						<div class="archive-description category-description"><?php echo $category_description; ?></div>
						
					<?php }
				} elseif ( $template->is( 'tag' ) ) {
					$tag_description = tag_description();
					
					if ( $tag_description ) { ?>
					
						<div class="archive-description tag-description"><?php echo $tag_description; ?></div>
						
					<?php }
				} elseif ( $template->is( 'author' ) ) {
					$author_description = get_the_author_meta( 'description', $author_id );
					
					if ( $author_description ) { ?>
					
						<div class="archive-description author-description"><?php echo $author_description; ?></div>
						
					<?php }
				} ?>
			
			</header>
		
		<?php }
		
		if ( $template->is( 'search' ) ) {
			get_search_form( true );
		}
		
		/**
		 * Do action before content
		 * 
		 * @action		jentil_before_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_before_content' );
		
		if ( $template->is( '404' ) || ! $query ) { ?>
		
			<div class="posts-wrap">
				<article class="post-wrap post-0" itemscope itemtype="http://schema.org/Article">
					<h2 class="entry-title" itemprop="name headline"><?php esc_html_e( 'Nothing found', 'jentil' ); ?></h2>
				
					<div class="entry-content self-clear" itemprop="articleBody">
						<?php
						/**
						 * Filter the nothing found page content.
						 * 
						 * @var         string          $not_found_content         Not found page content.
						 * @filter		jentil_not_found_content
						 *
						 * @since       Jentil 0.1.0
						 */
						$not_found_content = wp_kses_post( apply_filters(
							'jentil_not_found_content',
							'<p>' . esc_html__( 'Sorry, nothing here ):', 'jentil' ) . '</p>',
							$template->type()
						) );
						
						echo $not_found_content; ?>
						
					</div><!-- .entry-content -->
				</article>
			</div>
		
		<?php } else {
			echo $query;
		}
		
		/**
		 * Do action after content
		 * 
		 * @action		jentil_after_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_after_content' );
		
		if ( $template->is( 'singular' ) ) {
			the_post();
			
			if ( 'open' == get_option( 'default_ping_status' ) ) {
				echo '<!--'; trackback_rdf(); echo '-->';
			}
			
			comments_template( '', true );
			
			rewind_posts();
		} ?>
		
	</main><!-- #content -->
</div><!-- #container -->

<?php

get_sidebar();

get_footer();