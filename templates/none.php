<?php

/**
 * Template Part: Nothing found
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Utilities;

?>

<div class="posts-wrap">
	<article class="post-wrap post-0" itemscope itemtype="http://schema.org/Article">
		<div class="entry-content self-clear" itemprop="articleBody"><?php

			/**
			 * Filter the nothing found page content.
			 * 
			 * @var         string 		$jentil_nothing_found_content 		Not found page content.
			 *
			 * @filter		jentil_nothing_found_content
			 *
			 * @since       Jentil 0.1.0
			 */
			$jentil_not_found = apply_filters(
				'jentil_nothing_found_content',
				'<h2 class="entry-title" itemprop="name headline">' . esc_html__( 'Nothing Found', 'jentil' ) . '</h2>'
				
				. '<p>' . esc_html__( 'Sorry, nothing here ):', 'jentil' ) . '</p>',
				Utilities\Template\Template::instance()->type()
			);
			
			echo $jentil_not_found;

		?></div><!-- .entry-content -->
	</article>
</div>