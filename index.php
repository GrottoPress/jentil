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

global $post;

$template = new \GrottoPress\Jentil\Template\Template();

$excerpt			= $template->is( 'search' ) ? '200' : 'content';
$search 			= $template->is( 'search' ) ? get_search_query() : '';
$img				= $template->is( 'search' ) ? 'nano-thumb' : '';
$num				= $template->is( 'singular' ) ? 1 : absint( get_option( 'posts_per_page' ) );
$pag_pos			= $template->is( 'singular' ) ? '' : 'bottom';

$after_title		= ! $template->is( 'singular' ) ? 'published_date,comments_link' : '';
$after_title		= $template->is( 'search' ) ? 'post_type,published_date' : $after_title;
$after_title		= $template->is( 'singular', 'post' ) ? 'single_post_entry_meta' : $after_title;

$after_content		= $template->is( 'home' ) || $template->is( 'archive' ) ? 'category, post_tag' : '';

$wrap_class 		= $template->is( 'singular' ) ? 'singular-post' : 'archive-posts';
$wrap_class 		.= $template->is( 'search' ) ? 'small' : 'big';

$title_tag			= $template->is( 'singular' ) ? 'h1' : 'h2';
$title_link 		= $template->is( 'singular' ) ? 'false' : '';

$orderby			= $template->is( 'search' ) ? 'all_time_views' : '';
$orderby_2			= $template->is( 'search' ) ? 'comment_count' : '';

$day				= get_query_var( 'day' );
$month				= get_query_var( 'monthnum' );
$year				= get_query_var( 'year' );

$cat_id 			= get_query_var( 'cat' );
$cat_inc			= join( ',', get_query_var( 'category__in' ) );
$cat_exc			= join( ',', get_query_var( 'category__not_in' ) );
$cat_int			= join( ',', get_query_var( 'category__and' ) );

$tag_id 			= get_query_var( 'tag_id' );
$tag_inc			= join( ',', get_query_var( 'tag__in' ) );
$tag_exc			= join( ',', get_query_var( 'tag__not_in' ) );
$tag_int			= join( ',', get_query_var( 'tag__and' ) );

$tax_slug			= get_query_var( 'taxonomy' );
//$tax_name 		= ! empty( $tax_slug ) ? get_taxonomy( $tax_slug )->labels->singular_name : '';
$term_id			= get_query_var( 'term_id' );
//$term_name		= ! empty( $term_slug ) ? get_term_by( 'slug', $term_slug, $tax_slug )->name : '';

$author_id			= get_query_var( 'author' );
//$author_slug		= get_query_var( 'author_name' );

$post_type			= get_query_var( 'post_type' ) ? get_query_var( 'post_type' ) : '';
$post_type			= $template->is( 'search' ) ? get_post_types( array( 'public' => true ) ) : $post_type;
$post_type			= $template->is( 'singular' ) ? $post->post_type : $post_type;
$post_type			= $template->is( 'home' ) ? 'post' : $post_type; //get_post_types( array( 'public' => true, 'hierarchical' => false ) )
$post_type			= is_array( $post_type ) ? join( ',', $post_type ) : $post_type;

$post_id			= $template->is( 'single' ) ? $post->ID : '';
$page_id			= $template->is( 'page' ) ? $post->ID : '';

// Testing
//echo $post_id . ' ';
//echo $page_id . ' ';
//echo $post_type . ' ';
//echo get_query_var( 'post_type' );

$query = do_shortcode( '[magpack_posts post_type="' . $post_type . '" cat_id="' . $cat_id . '" cat_inc="' . $cat_inc . '" cat_exc="' . $cat_exc . '" cat_int="' . $cat_int . '" tag_id="' . $tag_id . '" tag_inc="' . $tag_inc . '" tag_exc="' . $tag_exc . '" tag_int="' . $tag_exc . '" tax="' . $tax_slug . '" tax_term="' . $term_id . '" num="' . $num . '" title_pos="top" img="' . $img . '" after_title="' . $after_title . '" after_content="' . $after_content . '" before_title="" excerpt="' . $excerpt . '" date_year="' . $year . '" date_month="' . $month . '" date_day="' . $day . '" author_id="' . $author_id . '" content_pag="true" pag="nav,num" pag_pos="' . $pag_pos . '" class="' . $wrap_class . '" search="' . $search . '" post_id="' . $post_id . '" page_id="' . $page_id . '" id="" title_tag="' . $title_tag . '" title_link="' . $title_link . '" orderby="' . $orderby . '" orderby_2="' . $orderby_2 . '"]' );

get_header();

?>

<div id="container">
	<div id="content" class="site-content">
		
		<?php do_action( 'jentil_before_title' ); ?>
		
		<?php if ( ! $template->is( 'singular' ) ) { ?>
		
			<h1 class="page-title entry-title" itemprop="name"><?php echo $template->title(); ?></h1>
			
		<?php } ?>
			
		<?php if ( $template->is( 'category' ) ) {
			$category_description = category_description();
			
			if ( ! empty( $category_description ) ) { ?>
			
				<div class="archive-description category-description"><?php echo $category_description; ?></div>
				
			<?php }
		} elseif ( $template->is( 'tag' ) ) {
			$tag_description = tag_description();
			
			if ( ! empty( $tag_description ) ) { ?>
			
				<div class="archive-description tag-description"><?php echo $tag_description; ?></div>
				
			<?php }
		} elseif ( $template->is( 'author' ) ) {
			$author_description = get_the_author_meta( 'description', $author_id );
			
			if ( ! empty( $author_description ) ) { ?>
			
				<div class="archive-description author-description"><?php echo $author_description; ?></div>
				
			<?php }
		} elseif ( $template->is( 'search' ) ) {
			get_search_form( true );
		}
		
		if ( $template->is( '404' ) || empty( $query ) ) { ?>
		
			<div class="posts-container">
				<article class="post-0 self-clear" itemscope itemtype="http://schema.org/Article">
					<h2 class="entry-title" itemprop="name headline"><?php esc_html_e( 'Nothing found', 'magpress' ); ?></h2>
				
					<div class="entry-content self-clear" itemprop="articleBody">
						<p><?php esc_html_e( 'Sorry, nothing here ):', 'magpress' ); ?></p>
					</div><!-- .entry-content -->
				</article>
			</div>
		
		<?php } else {
			echo $query;
		}
		
		if ( $template->is( 'singular' ) ) {
			the_post();
			
			if ( 'open' == get_option( 'default_ping_status' ) ) {
				echo '<!--'; trackback_rdf(); echo '-->';
			}
			
			comments_template( '', true );
			
			rewind_posts();
		} ?>
		
	</div><!-- #content -->
</div><!-- #container -->

<?php

get_sidebar();

get_footer();