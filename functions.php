<?php

/**
 * Functions
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @see https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

/**
 * Autoloader
 *
 * @since 0.1.0
 */
(function ($basePath) {
    $path = $basePath.'/vendor/autoload.php';
    file_exists($path) && require($path);
})(__DIR__);

/**
 * Run this theme.
 *
 * @action after_setup_theme
 *
 * @since 0.1.0
 */
\add_action('after_setup_theme', function () {
    \Jentil()->run();
}, 0);
