<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header', 'micro');

\do_action('jentil_before_header'); ?>

<header id="header" class="site-header" itemscope itemtype="http://schema.org/WPHeader">
    <?php \do_action('jentil_inside_header'); ?>
</header><!-- #header -->

<?php \do_action('jentil_after_header'); ?>

<div id="main">
