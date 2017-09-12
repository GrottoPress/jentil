<?php

/**
 * Template Part: 404
 *
 * This contains code that would be included in
 * other templates via the `\get_template_part()` call.
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1); ?>

<div class="posts-wrap">
    <article class="post-wrap post-0" itemscope itemtype="http://schema.org/Article">
        <div class="entry-content self-clear" itemprop="articleBody">
            <?php
            /**
             * @filter jentil_nothing_found_content
             *
             * @since 0.1.0
             */
            echo \apply_filters(
                'jentil_nothing_found_content',
                '<h2 class="entry-title" itemprop="name headline">'.
                    \esc_html__('Nothing Found', 'jentil').
                '</h2>'
                .'<p>'.\esc_html__('Sorry, nothing here):', 'jentil').'</p>',
                \Jentil()->utilities()->page()->type()
            ); ?>
        </div><!-- .entry-content -->
    </article>
</div>
