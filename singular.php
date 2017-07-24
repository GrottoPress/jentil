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
 * Include templates head
 *
 * @since		Jentil 0.1.0
 */
get_header();

the_post(); ?>

<div class="posts-wrap show-content big singular-post">
	<article data-post-id="<?php the_ID(); ?>" id="post-<?php the_ID(); ?>" <?php post_class( [ 'post-wrap' ] ); ?> itemscope itemtype="http://schema.org/Article">

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

			the_title( '<h1 class="entry-title" itemprop="name headline mainEntityOfPage">', '</h1>' );
			
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

			wp_link_pages( [
				'before' => '<nav class="page-links pagination p">'
					. esc_html__( 'Pages: ', 'jentil' ),
				'after' => '</nav>',
			] ); ?>
			
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
 * Include templates foot
 *
 * @since		Jentil 0.1.0
 */
get_footer();