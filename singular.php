<?php

/**
 * Singular template
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Begin template rendering
 * 
 * @since		Jentil 0.1.0
 */

get_header();

?>

<div id="content-wrap" class="p">
	<main id="content" class="site-content">
		
		<?php
		/**
		 * Do action before title
		 * 
		 * @action		jentil_before_before_title
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_before_before_title' );
		
		the_post(); ?>

		<div class="posts-wrap show-content big singular-post">
			<article data-post-id="<?php the_ID(); ?>" id="post-<?php the_ID(); ?>" <?php post_class( array( 'post-wrap' ) ); ?> itemscope itemtype="http://schema.org/Article">

				<?php if ( $post->post_title ) { ?>

					<header class="p">

				<?php }

					/**
					 * Do action before title
					 * 
					 * @action		jentil_before_title
					 *
					 * @since       Jentil 0.1.0
					 */
					do_action( 'jentil_before_title' );

					the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
					
					rewind_posts();
					
					/**
					 * Do action after title
					 * 
					 * @action		jentil_after_title
					 *
					 * @since       Jentil 0.1.0
					 */
		 			do_action( 'jentil_after_title' );

		 		if ( $post->post_title ) { ?>
			 		
					</header>

				<?php }
				
				/**
				 * Do action before content
				 * 
				 * @action		jentil_before_content
				 *
				 * @since       Jentil 0.1.0
				 */
			 	do_action( 'jentil_before_content' );

			 	the_post(); ?>
				
				<div class="entry-content self-clear" itemprop="articleBody">

					<?php the_content();

					wp_link_pages( array(
						'before' => '<nav class="page-links pagination p">'
							. esc_html__( 'Pages: ', 'jentil' ),
						'after' => '</nav>',
					) ); ?>
					
				</div><!-- .entry-content -->

				<?php
				/**
				 * Do action after content
				 * 
				 * @action		jentil_after_content
				 *
				 * @since       Jentil 0.1.0
				 */
				do_action( 'jentil_after_content' ); ?>

			</article>
		</div>

		<?php rewind_posts();

		/**
		 * Do action after content
		 * 
		 * @action		jentil_after_after_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_after_after_content' );
		
		the_post();
		
		if ( 'open' == get_option( 'default_ping_status' ) ) {
			echo '<!--'; trackback_rdf(); echo '-->';
		}
		
		comments_template( '', true );
		
		rewind_posts(); ?>
		
	</main><!-- #content -->
</div><!-- #content-wrap -->

<?php

get_sidebar();

get_footer();