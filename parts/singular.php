<?php

/**
 * Template Part: Singular
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

?>

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

	 	the_post(); ?>
		
		<div class="entry-content self-clear" itemprop="articleBody">

			<?php the_content();

			wp_link_pages( array(
				'before' => '<p class="page-links pagination">'
					. esc_html__( 'Pages: ', 'jentil' ),
				'after' => '</p>',
			) ); ?>
			
		</div><!-- .entry-content -->
	</article>
</div>