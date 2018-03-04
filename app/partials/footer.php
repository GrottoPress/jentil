<?php
declare (strict_types = 1);

        \do_action('jentil_after_after_content');

        /**
         * Load comments
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

\Jentil()->utilities->loader->loadPartial('sidebar');

\Jentil()->utilities->loader->loadPartial('footer', 'mini');
