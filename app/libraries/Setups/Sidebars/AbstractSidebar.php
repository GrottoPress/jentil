<?php

/**
 * Abstract sidebar
 *
 * @package GrottoPress\Jentil\Setups\Sidebars
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Sidebars;

use GrottoPress\Jentil\Setups\AbstractSetup;

/**
 * Abstract sidebar
 *
 * @since 0.6.0
 */
abstract class AbstractSidebar extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.6.0
     * @access public
     */
    public function run()
    {
        \add_action('widgets_init', [$this, 'register']);
    }

    /**
     * Register widget area
     *
     * @since 0.6.0
     * @access public
     *
     * @action widgets_init
     */
    abstract public function register();
}
