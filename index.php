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
 * Include templates head
 *
 * @since		Jentil 0.1.0
 */
get_header();

if ( ! ( $jentil_template = Utilities\Template\Template::instance() )->is( 'singular' ) ) {
	if ( ( $jentil_title = $jentil_template->get( 'title' )->mod() ) ) { ?>
		
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

		echo $jentil_title;
		
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

	if ( $jentil_title ) { ?>
	
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
	get_template_part( 'templates/none' );
} else {
	echo $jentil_posts;
}

/**
 * Include templates foot
 *
 * @since		Jentil 0.1.0
 */
get_footer();