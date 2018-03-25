<?php
declare (strict_types = 1);

        \do_action('woocommerce_after_main_content'); ?>
    </main><!-- #content -->
</div><!-- #content-wrap -->

<?php

// \do_action('woocommerce_sidebar');

\Jentil()->utilities->loader->loadPartial('sidebar', 'shop');

\Jentil()->utilities->loader->loadPartial('footer', 'mini');
