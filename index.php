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
 * @var 	\GrottoPress\Jentil\Utilities\Template\Template 	$jentil_template 	Template
 * 
 * @since		Jentil 0.1.0
 */
$jentil_template = new Utilities\Template\Template();

/**
 * Begin template rendering
 * 
 * @since		Jentil 0.1.0
 */

get_header();

?>

<div id="content-wrap" class="margin-vertical">
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
		
		if ( ! $jentil_template->is( 'singular' ) ) {
			$title = $jentil_template->get( 'title' )->mod();
			$description = $jentil_template->description();

			if ( $description || $title ) { ?>
				
				<header class="margin-vertical">

			<?php }

			if ( $title ) { ?>
				<h1 class="page-title entry-title" itemprop="name"><?php

					echo $title;
					
				?></h1>
			<?php }
			
			/**
			 * Do action after title
			 * 
			 * @action		jentil_after_title
			 *
			 * @since       Jentil 0.1.0
			 */
			do_action( 'jentil_after_title' );
	
			if ( $description ) { ?>
				
				<div class="archive-description margin-vertical" itemprop="description"><?php

					echo $description;

				?></div>
					
			<?php }

			if ( $description || $title ) { ?>
			
				</header>

			<?php } ?>
		
		<?php }
		
		if ( $jentil_template->is( 'search' ) ) {
			get_search_form();
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
		 * @action		jentil_after_content
		 *
		 * @since       Jentil 0.1.0
		 */
		do_action( 'jentil_after_content' );
		
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