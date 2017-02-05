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

/**
 * Template
 *
 * @var 	\GrottoPress\Jentil\Utilities\Template\Template 	$template 	Template
 * 
 * @since		Jentil 0.1.0
 */
$template = new Utilities\Template\Template();

/**
 * Posts
 *
 * @var 		string 		$query 		Queried posts
 * 
 * @since		Jentil 0.1.0
 */
$query = $template->get( 'posts' )->query();

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

					<?php echo $template->get( 'title' )->title(); ?>
					
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