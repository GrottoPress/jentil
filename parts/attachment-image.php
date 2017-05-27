<?php

/**
 * Template Part: Image
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

/**
 * Filter the previous and next labels.
 * 
 * @var         string          $prev_label         Previous label.
 * @var         string          $next_label         Next label.
 * 
 * @filter		jentil_pagination_prev_label
 * @filter		jentil_pagination_next_label
 *
 * @since       Jentil 0.1.0
 */
$prev_label = sanitize_text_field( apply_filters( 'jentil_pagination_prev_label', __( '&larr; Previous', 'jentil' ), 'image' ) );
$next_label = sanitize_text_field( apply_filters( 'jentil_pagination_next_label', __( 'Next &rarr;', 'jentil' ), 'image' ) ); ?>
	
<nav id="image-navigation" class="navigation image-navigation pagination self-clear">
	<div class="prev"><?php previous_image_link( 0, $prev_label ); ?></div>
	<div class="next"><?php next_image_link( 0, $next_label ); ?></div>
</nav><!-- .image-navigation -->

<figure class="entry-attachment image aligncenter">
	
	<?php
    /**
	 * Filter the default image attachment size.
	 * 
	 * @var         string          $image_size         Image size. Default 'large'.
	 *
	 * @since       Jentil 0.1.0
	 */
	$image_size = apply_filters( 'jentil_attachment_size', 'large' ); ?>
			
	<div class="image-wrap"><a href="<?php echo wp_get_attachment_url( $post->id ); ?>" rel="attachment" itemprop="url"><?php

		echo wp_get_attachment_image( $post->ID, $image_size );

	?></a></div>
	
	<?php if ( ! empty( $post->post_excerpt ) ) { ?>

		<figcaption class="entry-caption wp-caption-text" itemprop="description"><?php

			echo wp_kses_data( $post->post_excerpt );

		?></figcaption>

	<?php } ?>
	
</figure>