<?php
declare (strict_types = 1); ?>

<div class="entry-attachment">
    <?= \do_shortcode('[audio src="'.\wp_get_attachment_url($post->ID).'"]'); ?>

    <p><a href="<?=
        \wp_get_attachment_url($post->ID);
    ?>" rel="attachment" itemprop="url"><?=
        \basename($post->guid);
    ?></a></p>

    <?php if ($post->post_excerpt) { ?>
        <p class="entry-caption wp-caption-text" itemprop="description"><?php
            the_excerpt();
        ?></p>
    <?php } ?>
</div>
