<?php

/**
 * Template Part: Image
 *
 * This contains code that would be included in
 * other templates via the `\get_template_part()` call.
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
 * @filter jentil_pagination_prev_label
 *
 * @var string $prev_label Previous label.
 * 
 * @since 0.1.0
 */
$prev_label = \sanitize_text_field( \apply_filters( 'jentil_pagination_prev_label', \__( '&larr; Previous', 'jentil' ), 'image' ) );

/**
 * @filter jentil_pagination_next_label
 *
 * @var string $next_label Next label.
 *
 * @since 0.1.0
 */
$next_label = \sanitize_text_field( \apply_filters( 'jentil_pagination_next_label', \__( 'Next &rarr;', 'jentil' ), 'image' ) ); ?>

<nav id="image-navigation" class="navigation image-navigation pagination self-clear">
	<div class="prev"><?php \previous_image_link( 0, $prev_label ); ?></div>
	<div class="next"><?php \next_image_link( 0, $next_label ); ?></div>
</nav><!-- .image-navigation -->

<figure class="entry-attachment image aligncenter">
	
	<?php
    /**
	 * @filter jentil_attachment_size
	 * 
	 * @var string $image_size Image size. Default 'large'.
	 *
	 * @since 0.1.0
	 */
	$image_size = \apply_filters( 'jentil_attachment_size', 'large' ); ?>
			
	<div class="image-wrap"><a href="<?php echo \wp_get_attachment_url( $post->id ); ?>" rel="attachment" itemprop="url"><?php

		echo \wp_get_attachment_image( $post->ID, $image_size );

	?></a></div>
	
	<?php if ( $post->post_excerpt ) { ?>

		<figcaption class="entry-caption wp-caption-text" itemprop="description"><?php

			echo \wp_kses_data( $post->post_excerpt );

		?></figcaption>

	<?php } ?>
	
</figure>
