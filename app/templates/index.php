<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header');

if (!\Jentil()->utilities->page->is('singular')) {
    if (($jentil_title = \Jentil()->utilities->page->title->themeMod()->get())
        || \Jentil()->utilities->page->is('customize_preview')
    ) { ?>
        <header class="page-header">
            <?php \do_action('jentil_before_title'); ?>

            <h1 class="page-title entry-title" itemprop="name mainEntityOfPage"><?php
                echo $jentil_title;
            ?></h1>

            <?php \do_action('jentil_after_title'); ?>
        </header>
    <?php }
}

/**
 * Prevent calls to `global $jentil_title`.
 */
unset($jentil_title);

\do_action('jentil_before_content');

if (\Jentil()->utilities->page->is('404')
    || !($jentil_posts = \Jentil()->utilities->page->posts->render())
) {
    \Jentil()->utilities->loader->loadPartial('none');
} else {
    echo $jentil_posts;
}

/**
 * Prevent calls to `global $jentil_posts`.
 */
unset($jentil_posts);

\do_action('jentil_after_content');

\Jentil()->utilities->loader->loadPartial('footer');
