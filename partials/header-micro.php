<?php
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

        <?php if (\Jentil()->utilities->page->is('singular') &&
            \pings_open(\get_queried_object())
        ) { ?>
            <link rel="pingback" href="<?php \bloginfo('pingback_url'); ?>" />
        <?php } ?>

        <!--[if lt IE 9]>
            <script src="<?=
                \Jentil()->utilities->fileSystem->dir(
                    'url',
                    '/dist/vendor/html5shiv.js'
                );
            ?>"></script>
            <script src="<?=
                \Jentil()->utilities->fileSystem->dir(
                    'url',
                    '/dist/vendor/respond.js'
                );
            ?>"></script>
        <![endif]-->

        <?php \wp_head(); ?>
    </head>

    <body <?php \body_class(); ?>>
        <?php \do_action('wp_body_open');

        \do_action('jentil_before_header');
