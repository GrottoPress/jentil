<?php
declare (strict_types = 1);

$prev_label = \sanitize_text_field(
    \apply_filters(
        'jentil_pagination_prev_label',
        \__('&larr; Previous', 'jentil'),
        'image'
    )
);

$next_label = \sanitize_text_field(
    \apply_filters(
        'jentil_pagination_next_label',
        \__('Next &rarr;', 'jentil'),
        'image'
    )
); ?>

<nav id="image-navigation" class="image-pagination pagination">
    <div class="prev"><?php \previous_image_link(0, $prev_label); ?></div>
    <div class="next"><?php \next_image_link(0, $next_label); ?></div>
</nav><!-- .image-navigation -->

<figure class="entry-attachment image aligncenter">
    <div class="image-wrap"><a href="<?php
        echo \wp_get_attachment_url($post->id);
    ?>" rel="attachment" itemprop="url"><?php
        echo \wp_get_attachment_image($post->ID, \apply_filters(
            'jentil_attachment_size',
            'large'
        ));
    ?></a></div>

    <?php if ($post->post_excerpt) { ?>
        <figcaption class="entry-caption wp-caption-text" itemprop="description">
            <?php the_excerpt(); ?>
        </figcaption>

    <?php } ?>
</figure>
