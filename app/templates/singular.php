<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header');

\the_post(); ?>

<div id="main-query" class="posts-wrap show-content big singular-post">
    <article data-post-id="<?php
        \the_ID();
    ?>" id="post-<?php \the_ID(); ?>" <?php
        \post_class(['post-wrap']);
    ?> itemscope itemtype="http://schema.org/Article">
        <?php if ($post->post_title) { ?>
            <header class="page-header">
        <?php }

        \do_action('jentil_before_title');

        \the_title(
            '<h1 class="entry-title" itemprop="name headline mainEntityOfPage">',
            '</h1>'
        );

        \do_action('jentil_after_title');

        if ($post->post_title) { ?>
            </header>
        <?php }

        \do_action('jentil_before_content'); ?>

        <div class="entry-content" itemprop="articleBody">
            <?php \the_content();

            \wp_link_pages([
                'before' => '<nav class="page-links pagination">'
                . \esc_html__('Pages: ', 'jentil'),
                'after' => '</nav>',
            ]); ?>
        </div><!-- .entry-content -->

        <?php \do_action('jentil_after_content'); ?>
    </article>
</div>

<?php \Jentil()->utilities->loader->loadPartial('footer');
