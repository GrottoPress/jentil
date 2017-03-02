<?php

/**
 * Template Part: Audio
 * 
 * @see 			http://codex.wordpress.org/Template_Hierarchy
 *
 * @link			https://jentil.grottopress.com
 * @package			jentil
 * @since			Jentil 0.1.0
 */

?>

<div class="entry-content self-clear" itemprop="articleBody">

	<?php echo do_shortcode( '[audio src="' . wp_get_attachment_url( $post->ID ) . '"]' ); ?>
	
	<p class="entry-attachment">
	    <a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" rel="attachment" itemprop="url"><?php

	    	echo basename( $post->guid );

	    ?></a>
    </p>
	
	<?php if ( ! empty( $post->post_excerpt ) ) { ?>

		<p class="entry-caption wp-caption-text" itemprop="description"><?php

			echo wp_kses_data( $post->post_excerpt );

		?></p>

	<?php }

	the_content();

	wp_link_pages( array(
		'before' => '<p class="page-links pagination">'
			. esc_html__( 'Pages: ', 'jentil' ),
		'after' => '</p>',
	) ); ?>
	
</div><!-- .entry-content -->