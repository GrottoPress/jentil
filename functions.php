<?php

/**
 * Functions
 *
 * Code in this file must be compatible with PHP 5.2,
 * until the check for PHP version is made.
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
require \get_template_directory().'/vendor/autoload.php';

/**
 * Run this theme.
 *
 * Ensure version requirements are met before
 * running theme.
 *
 * @action after_setup_theme
 *
 * @since 0.1.0
 */
\add_action('after_setup_theme', function () {
    \Jentil()->run();
}, 0);
