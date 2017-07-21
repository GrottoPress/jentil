<?php

/**
 * Template Part: Attachment
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

?>

<div class="entry-attachment">
    <p><a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" rel="attachment" itemprop="url"><?php

    	echo basename( $post->guid );

   ?></a></p>

	<?php if ( ! empty( $post->post_excerpt ) ) { ?>

		<p class="entry-caption wp-caption-text" itemprop="description"><?php

			echo wp_kses_data( $post->post_excerpt );

		?></p>

	<?php } ?>

</div>