<?php

/**
 * Template Part: Attachment
 *
 * This contains code that would be included in
 * other templates via the `\jentil_get_template()` call.
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

?>

<div class="entry-attachment">
    <p><a href="<?php echo \wp_get_attachment_url( $post->ID ); ?>" rel="attachment" itemprop="url"><?php

        echo \basename( $post->guid );

   ?></a></p>

    <?php if ( $post->post_excerpt ) { ?>

        <p class="entry-caption wp-caption-text" itemprop="description"><?php

            echo \wp_kses_data( $post->post_excerpt );

        ?></p>

    <?php } ?>

</div>
