<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header-shop');

\the_post();

\wc_get_template_part('content', 'single-product');

\Jentil()->utilities->loader->loadPartial('footer-shop');
