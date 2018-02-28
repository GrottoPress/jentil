<?php

/**
 * Main Menu
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

/**
 * Main Menu
 *
 * @since 0.1.0
 */
final class Menu extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'register']);
    }

    /**
     * Menus
     *
     * Register navigation menus
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function register()
    {
        \register_nav_menus([
            'primary-menu' => \esc_html__('Primary menu', 'jentil'),
        ]);
    }
}
