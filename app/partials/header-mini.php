<?php

/**
 * Header Template: Mini
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

/**
 * Load reduced header template
 *
 * @since 0.5.0
 */
\Jentil()->utilities->loader->loadPartial('header', 'micro'); ?>

<?php
/**
 * @action jentil_before_header
 *
 * @since 0.1.0
 */
\do_action('jentil_before_header'); ?>

<header id="header" class="site-header" itemscope itemtype="http://schema.org/WPHeader">
    <?php
    /**
     * @action jentil_inside_header
     *
     * @since 0.1.0
     */
    \do_action('jentil_inside_header'); ?>
</header><!-- #header -->

<?php
/**
 * @action jentil_after_header
 *
 * @since 0.1.0
 */
\do_action('jentil_after_header'); ?>

<div id="main">
