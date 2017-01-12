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

use \GrottoPress\Jentil\Utilities as Utilities;

global $post;

$template = new Utilities\Template\Template();

/**
 * Get variables relevant to our
 * query shortcode
 * 
 * @since		Jentil 0.1.0
 */

$posts_per_page = get_option( 'posts_per_page' );

$sticky_posts	= $template->is( 'singular' )
				  ? 0
				  : $template->content()->get( 'sticky_posts', 1 );

$excerpt		= $template->is( 'singular' )
				  ? 'content'
				  : $template->content()->get( 'excerpt', 300 );

$search 		= $template->is( 'search' ) ? get_search_query() : '';

$num			= $template->is( 'singular' )
				  ? 1
				  : $template->content()->get( 'number', $posts_per_page );

$pag_pos		= $template->is( 'singular' )
				  ? ''
				  : $template->content()->get( 'pagination', 'bottom' );

$text_offset	= $template->is( 'singular' )
				  ? ''
				  : $template->content()->get( 'text_offset' );

$wrap_class 	= $template->is( 'singular' )
				  ? 'singular-post' : $template->content()->get( 'class', 'archive-posts big' );

$layout			= $template->is( 'singular' )
				  ? 'stack'
				  : $template->content()->get( 'layout', 'stack' );

$img			= $template->is( 'singular' )
				  ? ''
				  : $template->content()->get( 'thumbnail', 'mini-thumb' );

$img_align		= $template->is( 'singular' )
				  ? ''
				  : $template->content()->get( 'thumbnail_alignment', 'left' );

$before_title	= $template->is( 'singular' )
				  ? ''
				  : $template->content()->get( 'before_title' );

$after_title	= $template->is( 'singular', 'post' )
				  ? 'jentil_single_post_after_title'
				  : '';

$after_title	= ! $template->is( 'singular' )
				  ? $template->content()->get( 'after_title', 'published_date, comments_link' )
				  : $after_title;

$after_content	= $template->is( 'singular' )
				  ? ''
				  : $template->content()->get( 'after_content', 'category, post_tag' );

$title			= $template->is( 'singular' )
				  ? -1
				  : $template->content()->get( 'title_words', -1 );

$title_pos		= $template->is( 'singular' )
				  ? 'top'
				  : $template->content()->get( 'title_position', 'side' );

$title_tag		= $template->is( 'singular' ) ? 'h1' : 'h2';
$title_link 	= $template->is( 'singular' ) ? 0 : 1;

$orderby		= $template->is( 'search' ) ? 'all_time_views' : '';
$orderby_2		= $template->is( 'search' ) ? 'comment_count' : '';

$day			= get_query_var( 'day' );
$month			= get_query_var( 'monthnum' );
$year			= get_query_var( 'year' );

$cat_id 		= get_query_var( 'cat' );
$cat_in			= join( ',', get_query_var( 'category__in' ) );
$cat_not_in		= join( ',', get_query_var( 'category__not_in' ) );
$cat_and		= join( ',', get_query_var( 'category__and' ) );

$tag_id 		= get_query_var( 'tag_id' );
$tag_in			= join( ',', get_query_var( 'tag__in' ) );
$tag_not_in		= join( ',', get_query_var( 'tag__not_in' ) );
$tag_and		= join( ',', get_query_var( 'tag__and' ) );

$tax_slug		= get_query_var( 'taxonomy' );
//$tax_name 	= $tax_slug ? get_taxonomy( $tax_slug )->labels->singular_name : '';
$term_id		= get_query_var( 'term_id' );
$term_id		= is_array( $term_id ) ? join( ',', $term_id ) : $term_id;
//$term_name	= $term_slug ? get_term_by( 'slug', $term_slug, $tax_slug )->name : '';

$author_id		= get_query_var( 'author' );
//$author_slug	= get_query_var( 'author_name' );
$author_id		= is_array( $author_id )
				  ? join( ',', $author_id )
				  : $author_id;

$post_type		= get_query_var( 'post_type' )
				  ? get_query_var( 'post_type' )
				  : '';

$post_type		= $template->is( 'search' ) && ! $post_type
				  ? get_post_types( array( 'public' => true ) )
				  : $post_type;

$post_type		= $template->is( 'singular' )
				  ? $post->post_type
				  : $post_type;

$post_type		= is_array( $post_type )
				  ? join( ',', $post_type )
				  : sanitize_key( $post_type );

$post_id		= $template->is( 'single' ) ? $post->ID : '';
$page_id		= $template->is( 'page' ) ? $post->ID : '';
$post_not_in	= ! $template->is( 'singular' ) && $sticky_posts
				  ? 'sticky_posts'
				  : '';

/**
 * Get sticky post options
 *
 * @since		Jentil 0.1.0
 */

$sticky = new Utilities\Sticky();

$s_img 				= $sticky->get( 'thumbnail', 'mini-thumb' );
$s_img_align		= $sticky->get( 'thumbnail_alignment', 'left' );

$s_excerpt			= $sticky->get( 'excerpt', '300' );
$s_num				= $sticky->get( 'number', $posts_per_page );
$s_wrap_class 		= $sticky->get( 'class', 'sticky-posts big' );
$s_text_offset		= $sticky->get( 'text_offset' );
$s_pag_pos			= $sticky->get( 'pagination', 'none' );
$s_layout			= $sticky->get( 'layout', 'stack' );

$s_title_pos		= $sticky->get( 'title_position', 'side' );
$s_title			= $sticky->get( 'title_words', -1 );

$s_before_title		= $sticky->get( 'before_title' );
$s_after_title		= $sticky->get( 'after_title', 'published_date, comments_link' );
$s_after_content 	= $sticky->get( 'after_content', 'category, post_tag' );

// Debugging
// echo 'classes: ' . $wrap_class . '<br />';
// echo 'title_pos: ' . $title_pos . '<br />';
// echo 'img: ' . $img . '<br />';
// echo 'Template: '; print_r( $template->get() );
// End debugging

/**
 * The query shortcode
 * 
 * @since		Jentil 0.1.0
 */

$query = '';

if ( $sticky_posts && ! $template->is( 'singular' ) ) {
	$query .= do_shortcode( '[magpack_posts
		num="' . $s_num . '" 
		layout="' . $s_layout . '" 
		post_type="' . $post_type . '" 
		cat_id="' . $cat_id . '" 
		cat_in="' . $cat_in . '" 
		cat_not_in="' . $cat_not_in . '" 
		cat_and="' . $cat_and . '" 
		tag_id="' . $tag_id . '" 
		tag_in="' . $tag_in . '" 
		tag_not_in="' . $tag_not_in . '" 
		tag_and="' . $tag_and . '" 
		tax="' . $tax_slug . '" 
		tax_term="' . $term_id . '" 
		date_year="' . $year . '" 
		date_month="' . $month . '" 
		date_day="' . $day . '" 
		author_in="' . $author_id . '" 
		title_pos="' . $s_title_pos . '" 
		img="' . $s_img . '" 
		img_align="' . $s_img_align . '" 
		after_title="' . $s_after_title . '" 
		after_content="' . $s_after_content . '" 
		before_title="' . $s_before_title . '" 
		excerpt="' . $s_excerpt . '" 
		content_pag="1" 
		pag_pos="' . $s_pag_pos . '" 
		class="' . $s_wrap_class . '" 
		post_in="sticky_posts" 
		id="sticky-posts" 
		title_tag="' . $title_tag . '" 
		title_link="' . $title_link . '" 
		orderby="' . $orderby . '" 
		orderby_2="' . $orderby_2 . '" 
		text_offset="' . $s_text_offset . '"
	]' );
}

$query .= do_shortcode( '[magpack_posts 
	num="' . $num . '" 
	layout="' . $layout . '" 
	post_type="' . $post_type . '" 
	cat_id="' . $cat_id . '" 
	cat_in="' . $cat_in . '" 
	cat_not_in="' . $cat_not_in . '" 
	cat_and="' . $cat_and . '" 
	tag_id="' . $tag_id . '" 
	tag_in="' . $tag_in . '" 
	tag_not_in="' . $tag_not_in . '" 
	tag_and="' . $tag_and . '" 
	tax="' . $tax_slug . '" 
	tax_term="' . $term_id . '" 
	title_pos="' . $title_pos . '" 
	img="' . $img . '" 
	img_align="' . $img_align . '" 
	after_title="' . $after_title . '" 
	after_content="' . $after_content . '" 
	before_title="' . $before_title . '" 
	excerpt="' . $excerpt . '" 
	date_year="' . $year . '" 
	date_month="' . $month . '" 
	date_day="' . $day . '" 
	author_in="' . $author_id . '" 
	content_pag="1" 
	pag="nav,num" 
	pag_pos="' . $pag_pos . '" 
	class="' . $wrap_class . '" 
	search="' . $search . '" 
	post_in="' . $post_id . '" 
	post_not_in="' . $post_not_in . '" 
	page_id="' . $page_id . '" 
	id="" 
	title_tag="' . $title_tag . '" 
	title_link="' . $title_link . '" 
	orderby="' . $orderby . '" 
	orderby_2="' . $orderby_2 . '" 
	text_offset="' . $text_offset . '"
]' );

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
				<h1 class="page-title entry-title" itemprop="name"><?php echo $template->title()->get(); ?></h1>
				
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
							$template->get()
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