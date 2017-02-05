<?php

/**
 * Attachment template
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

the_post();
$magpack_post = new \GrottoPress\MagPack\Utilities\Post\Post( get_the_ID() );
rewind_posts();

get_header();

?>

<div id="container">
	<main id="content">
		
		<?php
		/**
		 * Do action before title
		 * 
		 * @action		jentil_before_title
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_before_title' );
		
		the_post();
		
		if ( $post->post_parent ) { ?>

			<h2 class="parent entry-title">
			    <a href="<?php echo get_permalink( $post->post_parent ); ?>" rev="attachment">
			    	<span class="meta-nav">&laquo;</span> <?php

			    	echo get_the_title( $post->post_parent );

			    ?></a>
	        </h2>

		<?php } ?>
		
		<div class="posts-wrap show-content big singular-post">
			<article data-post-id="<?php the_ID(); ?>" id="post-<?php the_ID(); ?>" <?php post_class( array( 'post-wrap' ) ); ?> itemscope itemtype="http://schema.org/Article">
				<header>

					<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
					
					rewind_posts();
					
					/**
					 * Do action after title
					 * 
					 * @action		jentil_after_title
					 *
					 * @since       Jentil 0.1.0
					 */
			 		do_action( 'jentil_after_title' ); ?>
			 		
				</header>
				
				<?php
				/**
				 * Do action before content
				 * 
				 * @action		jentil_before_content
				 *
				 * @since       Jentil 0.1.0
				 */
			 	do_action( 'jentil_before_content' ); ?>
				
				<div class="entry-content self-clear" itemprop="articleBody">
					<p class="entry-attachment">
					    <a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" rel="attachment" itemprop="url"><?php

					    	echo basename( $post->guid );

					   ?></a>
			        </p>
					
					<?php if ( ! empty( $post->post_excerpt ) ) { ?>

						<p class="entry-caption" itemprop="description"><?php

							echo wp_kses_data( $post->post_excerpt );

						?></p>

					<?php }
		
					echo $magpack_post->content( true ); ?>
					
				</div><!-- .entry-content -->
			</article>
		</div>
		
		<?php
		/**
		 * Do action after content
		 * 
		 * @action		jentil_after_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_after_content' );
		
		the_post();
		
		if ( 'open' == get_option( 'default_ping_status' ) ) {
			echo '<!--'; trackback_rdf(); echo '-->' ."\n";
		}
		
		comments_template( '', true );
		
		rewind_posts(); ?>
		
	</main><!-- #content -->
</div><!-- #container -->

<?php

get_sidebar();

get_footer();