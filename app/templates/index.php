<?php

/**
 * Index Template
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Load header template
 *
 * @since 0.1.0
 */
\Jentil()->utilities()->loader()->load_partial( 'header' );

if ( ! \Jentil()->utilities()->page()->is( 'singular' ) ) {
	if ( ( $jentil_title = \Jentil()->utilities()->page()->title() ) ) { ?>
		
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
	\Jentil()->utilities()->page()->is( '404' )
	|| ! ( $jentil_posts = \Jentil()->utilities()->page()->posts()->get() )
) {
	\Jentil()->utilities()->loader()->load_partial( 'none' );
} else {
	echo $jentil_posts;
}

/**
 * Load footer template
 *
 * @since 0.1.0
 */
\Jentil()->utilities()->loader()->load_partial( 'footer' );
