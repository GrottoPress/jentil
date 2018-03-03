<?php

/**
 * Footer Template
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

        /**
         * @action jentil_after_after_content
         *
         * @since 0.1.0
         */
        \do_action('jentil_after_after_content');

        /**
         * Load comments
         *
         * @since 0.1.0
         */
        if (\Jentil()->utilities->page->is('singular')) {
            if ('open' === \get_option('default_ping_status')) {
                echo '<!--';
                \trackback_rdf();
                echo '-->';
            }

            \Jentil()->utilities->loader->loadComments();
        } ?>
    </main><!-- #content -->
</div><!-- #content-wrap -->

<?php
/**
 * Load sidebars
 *
 * @since 0.1.0
 */
\Jentil()->utilities->loader->loadPartial('sidebar');

/**
 * Load reduced footer template
 *
 * @since 0.5.0
 */
\Jentil()->utilities->loader->loadPartial('footer', 'mini'); ?>
