<?php

/**
 * Logo
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

/**
 * Logo
 *
 * @since 0.1.0
 */
final class Logo extends Setup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
        \add_action('jentil_inside_header', [$this, 'render']);
    }

    /**
     * Add theme support for custom logo.
     *
     * @see https://codex.wordpress.org/Theme_Logo
     *
     * @since 0.1.0
     * @since WordPress 4.5
     *
     * @access public
     *
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('custom-logo', [
            'height' => 60,
            'width' => 180,
            'flex-width' => false,
            'flex-height' => false,
        ]);
    }

    /**
     * Render logo
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render()
    {
        echo \get_custom_logo();
    }
}
