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

				<?php if ( ( $title = the_title( '<h1 class="entry-title" itemprop="headline">',
					'</h1>', false ) ) ) { ?>

					<header>

				<?php }

					echo $title;
					
					rewind_posts();
					
					/**
					 * Do action after title
					 * 
					 * @action		jentil_after_title
					 *
					 * @since       Jentil 0.1.0
					 */
		 			do_action( 'jentil_after_title' );

		 		if ( $title ) { ?>
			 		
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

			 	the_post();

			 	if ( wp_attachment_is_image( $post->ID ) ) {
			 	 	get_template_part( 'parts/attachment', 'image' );
			 	} elseif ( wp_attachment_is( 'audio', $post->ID ) ) {
			 		get_template_part( 'parts/attachment', 'audio' );
			 	} elseif ( wp_attachment_is( 'video', $post->ID ) ) {
			 		get_template_part( 'parts/attachment', 'video' );
			 	} else {
			 		get_template_part( 'parts/attachment' );
			 	}

	 			rewind_posts();
		
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
		
		<?php the_post();
		
		if ( 'open' == get_option( 'default_ping_status' ) ) {
			echo '<!--'; trackback_rdf(); echo '-->';
		}
		
		comments_template( '', true );
		
		rewind_posts(); ?>
		
	</main><!-- #content -->
</div><!-- #container -->

<?php

get_sidebar();

get_footer();