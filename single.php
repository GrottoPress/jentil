<?php

/**
 * Single post template
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

the_post();
$magpack_post = new \GrottoPress\MagPack\Post\Post( get_the_ID() );
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
		 do_action( 'jentil_before_title' ); ?>
		
		<?php the_post(); ?>
		
		<div class="posts-wrap show-content big singular-post">
			<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'post-wrap' ) ); ?> itemscope itemtype="http://schema.org/Article">
				<header>
					<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
					
					<?php rewind_posts(); ?>
					
					<?php
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
					<?php echo $magpack_post->content( true ); ?>
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
		do_action( 'jentil_after_content' ); ?>
		
		<?php the_post(); ?>
		
		<?php if ( 'open' == get_option( 'default_ping_status' ) ) {
			echo '<!--'; trackback_rdf(); echo '-->' ."\n";
		} ?>
		
		<?php comments_template( '', true ); ?>
		
		<?php rewind_posts(); ?>
		
	</main><!-- #content -->
</div><!-- #container -->

<?php

get_sidebar();

get_footer();