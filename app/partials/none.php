<?php
declare (strict_types = 1); ?>

<div class="posts-wrap">
    <article class="post-wrap post-0" itemscope itemtype="http://schema.org/Article">
        <div class="entry-content" itemprop="articleBody">
            <?php echo \apply_filters(
                'jentil_nothing_found_content',
                '<h2 class="entry-title" itemprop="name headline">'.
                    \esc_html__('Nothing Found', 'jentil').
                '</h2>'
                .'<p>'.\esc_html__('Sorry, nothing here 😞', 'jentil').'</p>',
                \Jentil()->utilities->page->type
            ); ?>
        </div><!-- .entry-content -->
    </article>
</div>
