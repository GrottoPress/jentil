<?php

/**
 * Header Template
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

/**
 * Load reduced header template
 *
 * @since 0.5.0
 */
\Jentil()->utilities->loader->loadPartial('header', 'mini'); ?>

<div id="content-wrap">
    <main id="content" class="site-content">
        <?php
        /**
         * @action jentil_before_before_title
         *
         * @since 0.1.0
         */
        \do_action('jentil_before_before_title');
