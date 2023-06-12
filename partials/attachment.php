<?php
declare (strict_types = 1); ?>

<div class="entry-attachment">
    <p><a href="<?=
        \wp_get_attachment_url($post->ID);
    ?>" rel="attachment"><?=
        \basename($post->guid);
    ?></a></p>

    <?php if ($post->post_excerpt) { ?>
        <p class="entry-caption wp-caption-text"><?php
            \the_excerpt();
        ?></p>
    <?php } ?>
</div>
