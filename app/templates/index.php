<?php

/**
 * Index Template
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Include header template
 *
 * @since 0.1.0
 */
\get_template_part( 'app/partials/header' );

if ( ! ( $jentil_page = \Jentil()->utilities()->page() )->is( 'singular' ) ) {
	if ( ( $jentil_title = $jentil_page->title() ) ) { ?>
		
		<header class="p">

	<?php }

	/**
	 * @action jentil_before_title
	 *
	 * @since 0.1.0
	 */
	\do_action( 'jentil_before_title' ); ?>

	<h1 class="page-title entry-title" itemprop="name mainEntityOfPage"><?php

		echo $jentil_title;
		
	?></h1>

	<?php
	/**
	 * @action jentil_after_title
	 *
	 * @since 0.1.0
	 */
	\do_action( 'jentil_after_title' );

	if ( $jentil_title ) { ?>
	
		</header>

	<?php }
}

/**
 * @action jentil_before_content
 *
 * @since 0.1.0
 */
\do_action( 'jentil_before_content' );

if (
	$jentil_page->is( '404' )
	|| ! ( $jentil_posts = $jentil_page->posts()->get() )
) {
	\get_template_part( 'app/partials/none' );
} else {
	echo $jentil_posts;
}

/**
 * Include footer template
 *
 * @since 0.1.0
 */
\get_template_part( 'app/partials/footer' );
