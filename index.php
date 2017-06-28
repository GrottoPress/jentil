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

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Utilities;

/**
 * Template instance
 *
 * @since		Jentil 0.1.0
 */
$jentil_template = Utilities\Template\Template::instance();

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
		
		if ( ! $jentil_template->is( 'singular' ) ) {
			if ( ( $title = $jentil_template->get( 'title' )->mod() ) ) { ?>
				
				<header class="p">

			<?php }

			/**
			 * Do action before title
			 * 
			 * @action		jentil_before_title
			 *
			 * @since       Jentil 0.1.0
			 */
			do_action( 'jentil_before_title' ); ?>

			<h1 class="page-title entry-title" itemprop="name"><?php

				echo $title;
				
			?></h1>

			<?php
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
		}
		
		/**
		 * Do action before content
		 * 
		 * @action		jentil_before_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_before_content' );
		
		if (
			$jentil_template->is( '404' )
			|| ! ( $jentil_posts = $jentil_template->get( 'posts' )->query() )
		) {
			get_template_part( 'parts/none' );
		} else {
			echo $jentil_posts;
		}
		
		/**
		 * Do action after content
		 * 
		 * @action		jentil_after_after_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_after_after_content' );
		
		if ( $jentil_template->is( 'singular' ) ) {
			the_post();
			
			if ( 'open' == get_option( 'default_ping_status' ) ) {
				echo '<!--'; trackback_rdf(); echo '-->';
			}
			
			comments_template( '', true );
			
			rewind_posts();
		} ?>
		
	</main><!-- #content -->
</div><!-- #content-wrap -->

<?php

get_sidebar();

get_footer();