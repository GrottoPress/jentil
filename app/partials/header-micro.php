<?php

/**
 * Header Template: Start
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

?><!DOCTYPE html>
<html <?php \language_attributes(); ?>>
    <head>
        <meta charset="<?php \bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!--[if IE]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->

        <link rel="profile" href="http://gmpg.org/xfn/11" />

        <?php if (\Jentil()->utilities->page->is('singular')
            && \pings_open(\get_queried_object())
        ) { ?>
            <link rel="pingback" href="<?php \bloginfo('pingback_url'); ?>" />
        <?php } ?>

        <!--[if lt IE 9]>
            <script src="<?php
                echo \Jentil()->utilities->fileSystem->dir(
                    'url',
                    '/dist/vendor/html5shiv/dist/html5shiv.min.js'
                );
            ?>"></script>
            <script src="<?php
                echo \Jentil()->utilities->fileSystem->dir(
                    'url',
                    '/dist/vendor/respond.js/dest/respond.min.js'
                );
            ?>"></script>
        <![endif]-->

        <?php
        /**
         * @action wp_head
         *
         * @since 0.1.0
         */
        \wp_head(); ?>
    </head>

    <body <?php \body_class(); ?>>
        <div id="wrap" class="site hfeed">
