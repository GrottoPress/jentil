<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header', 'micro'); ?>

<header id="header" class="site-header">
    <?php \do_action('jentil_inside_header'); ?>
</header><!-- #header -->

<?php \do_action('jentil_after_header'); ?>

<main id="main">
    <?php \do_action('jentil_after_after_header'); ?>
