<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header', 'mini'); ?>

<div id="content-wrap">
    <main id="content" class="site-content">
        <?php \do_action('woocommerce_before_main_content');
