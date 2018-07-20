<?php
declare (strict_types = 1);

        \do_action('jentil_after_after_content');

        if (\Jentil()->utilities->page->is('singular')) {
            \Jentil()->utilities->loader->loadComments();
         } ?>
    </div><!-- #content -->
</div><!-- #content-wrap -->

<?php

\Jentil()->utilities->loader->loadPartial('sidebar');

\Jentil()->utilities->loader->loadPartial('footer', 'mini');
