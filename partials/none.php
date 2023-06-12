<?php
declare (strict_types = 1); ?>

<div class="posts-wrap">
    <article class="post-wrap post-0">
        <div class="entry-content">
            <?= \apply_filters(
                'jentil_nothing_found_content',
                '<h2 class="entry-title">'.
                    \esc_html__('Nothing Found', 'jentil').
                '</h2>'
                .'<p>'.\esc_html__('Sorry, nothing here 😞', 'jentil').'</p>',
                \Jentil()->utilities->page->type
            ); ?>
        </div><!-- .entry-content -->
    </article>
</div>
