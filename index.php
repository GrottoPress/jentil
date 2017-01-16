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

use GrottoPress\Jentil\Utilities;

$template = new Utilities\Template\Template();
$template_content = $template->get( 'content' );
$template_title = $template->get( 'title' );
$posts_per_page = get_option( 'posts_per_page' );

/**
 * Get variables relevant to our
 * posts shortcode
 * 
 * @since		Jentil 0.1.0
 */

if ( $template->is( 'singular' ) ) {
	global $post;

	$sticky_posts = 0;
	$excerpt = 'content';
	$search = '';
	$num = 1;
	$text_offset = '';
	$wrap_class = 'singular-post';
	$layout	= 'stack';
	$more_link = '';

	$pag = '';
	$pag_pos = '';

	$img = '';
	$img_align = '';
	$img_margin = '';

	$before_title = '';
	$after_title = $template->is( 'singular', 'post' ) ? 'jentil_single_post_after_title' : '';
	$after_content= '';

	$title = -1;
	$title_pos = 'top';
	$title_tag = 'h1';
	$title_link = 0;

	$orderby = '';
	$orderby_2 = '';

	$day = '';
	$month = '';
	$year = '';

	$cat_id = '';
	$cat_in	= '';
	$cat_not_in	= '';
	$cat_and = '';

	$tag_id = '';
	$tag_in	= '';
	$tag_not_in	= '';
	$tag_and = '';

	$tax_slug = '';
	//$tax_name = '';
	$term_id = '';
	$term_id = '';
	//$term_name = '';

	$author_id = '';
	//$author_slug = '';
	$author_id = '';

	$post_type = sanitize_key( $post->post_type );

	$post_id = absint( $post->ID );
	$post_not_in = '';
} else {
	$sticky_posts = $template_content->get_mod( 'sticky_posts', 1 );
	$excerpt = $template_content->get_mod( 'excerpt', 300 );
	$search = $template->is( 'search' ) ? get_search_query() : '';
	$num = $template_content->get_mod( 'number', $posts_per_page );
	$text_offset = $template_content->get_mod( 'text_offset' );
	$wrap_class = $template_content->get_mod( 'class', 'archive-posts big' );
	$layout	= $template_content->get_mod( 'layout', 'stack' );
	$more_link = $template_content->get_mod( 'more_link', esc_html__( 'read more', 'jentil' ) );

	$pag = 'nav, num';
	$pag_pos = $template_content->get_mod( 'pagination_position', 'bottom' );

	$img = $template_content->get_mod( 'image', 'mini-thumb' );
	$img_align = $template_content->get_mod( 'image_alignment', 'left' );
	$img_margin = $template_content->get_mod( 'image_margin' );

	$before_title = $template_content->get_mod( 'before_title' );
	$after_title = $template_content->get_mod( 'after_title', 'published_date, comments_link' );
	$after_content = $template_content->get_mod( 'after_content', 'category, post_tag' );

	$title = $template_content->get_mod( 'title_words', -1 );
	$title_pos = $template_content->get_mod( 'title_position', 'side' );
	$title_tag = 'h2';
	$title_link = 1;

	$orderby = $template->is( 'search' ) ? 'all_time_views' : '';
	$orderby_2 = $template->is( 'search' ) ? 'comment_count' : '';

	$day = get_query_var( 'day' );
	$month = get_query_var( 'monthnum' );
	$year = get_query_var( 'year' );

	$cat_id = get_query_var( 'cat' );
	$cat_in	= join( ',', get_query_var( 'category__in' ) );
	$cat_not_in	= join( ',', get_query_var( 'category__not_in' ) );
	$cat_and = join( ',', get_query_var( 'category__and' ) );

	$tag_id = get_query_var( 'tag_id' );
	$tag_in	= join( ',', get_query_var( 'tag__in' ) );
	$tag_not_in	= join( ',', get_query_var( 'tag__not_in' ) );
	$tag_and = join( ',', get_query_var( 'tag__and' ) );

	$tax_slug = get_query_var( 'taxonomy' );
	//$tax_name = $tax_slug ? get_taxonomy( $tax_slug )->labels->singular_name : '';
	$term_id = get_query_var( 'term_id' );
	$term_id = is_array( $term_id ) ? join( ',', $term_id ) : $term_id;
	//$term_name = $term_slug ? get_term_by( 'slug', $term_slug, $tax_slug )->name : '';

	$author_id = get_query_var( 'author' );
	//$author_slug = get_query_var( 'author_name' );
	$author_id = is_array( $author_id ) ? join( ',', $author_id ) : $author_id;

	$post_type = get_query_var( 'post_type' );
	$post_type = $template->is( 'search' ) && ! $post_type
		? get_post_types( array( 'public' => true, 'show_ui' => true ) )
		: $post_type;
	$post_type = is_array( $post_type )
		? join( ',', $post_type )
		: sanitize_key( $post_type );

	$post_id = '';
	$post_not_in = $sticky_posts ? 'sticky_posts' : '';

	/**
	 * Get sticky content settings
	 *
	 * @since		Jentil 0.1.0
	 */

	$sticky = new Utilities\Sticky();

	$s_img = $sticky->get_mod( 'image', 'mini-thumb' );
	$s_img_align = $sticky->get_mod( 'image_alignment', 'left' );
	$s_img_margin = $sticky->get_mod( 'image_margin' );

	$s_excerpt = $sticky->get_mod( 'excerpt', '300' );
	$s_num = $sticky->get_mod( 'number', 3 );
	$s_wrap_class = $sticky->get_mod( 'class', 'sticky-posts big' );
	$s_text_offset = $sticky->get_mod( 'text_offset' );
	$s_pag_pos = $sticky->get_mod( 'pagination_position', 'none' );
	$s_layout = $sticky->get_mod( 'layout', 'stack' );

	$s_title_pos = $sticky->get_mod( 'title_position', 'side' );
	$s_title = $sticky->get_mod( 'title_words', -1 );

	$s_before_title	= $sticky->get_mod( 'before_title' );
	$s_after_title = $sticky->get_mod( 'after_title', 'published_date, comments_link' );
	$s_after_content = $sticky->get_mod( 'after_content', 'category, post_tag' );
}

// Debugging
// echo 'classes: ' . $wrap_class . '<br />';
// echo 'title_pos: ' . $title_pos . '<br />';
//echo 'excerpt: ' . $excerpt . '<br />';
// echo 'Template: '; print_r( $template->get() );
//echo '<pre>'; print_r( get_taxonomy( 'category' ) ); echo '</pre>';
// End debugging

/**
 * The query shortcode
 * 
 * @since		Jentil 0.1.0
 */

$query = '';

if ( ! $template->is( 'singular' ) && $sticky_posts ) {
	$query .= do_shortcode(
		'[magpack_posts
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
			pag="' . $pag . '" 
			pag_pos="' . $s_pag_pos . '" 
			class="' . $s_wrap_class . '" 
			post_in="sticky_posts" 
			id="sticky-posts" 
			title_tag="' . $title_tag . '" 
			title_link="' . $title_link . '" 
			orderby="' . $orderby . '" 
			orderby_2="' . $orderby_2 . '" 
			text_offset="' . $s_text_offset . '" 
			more_link ="' . $more_link . '"
		]'
	);
}

$query .= do_shortcode(
	'[magpack_posts 
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
		pag="' . $pag . '" 
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
		more_link ="' . $more_link . '"
	]'
);

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