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
	
<nav id="image-navigation" class="navigation image-navigation pagination self-clear"><?php
	
	previous_image_link( false, $prev_label );
	next_image_link( false, $next_label );
	
?></nav><!-- .image-navigation -->

<div class="entry-content self-clear" itemprop="articleBody">
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
				
		<a href="<?php echo wp_get_attachment_url( $post->id ); ?>" rel="attachment" itemprop="url"><?php

			echo wp_get_attachment_image( $post->ID, $image_size );

		?></a>
		
		<?php if ( ! empty( $post->post_excerpt ) ) { ?>

			<figcaption class="entry-caption wp-caption-text" itemprop="description"><?php

				echo wp_kses_data( $post->post_excerpt );

			?></figcaption>

		<?php } ?>
		
	</figure>

	<?php the_content();

	wp_link_pages( array(
		'before' => '<p class="page-links pagination">'
			. esc_html__( 'Pages: ', 'jentil' ),
		'after' => '</p>',
	) ); ?>

</div><!-- .entry-content -->