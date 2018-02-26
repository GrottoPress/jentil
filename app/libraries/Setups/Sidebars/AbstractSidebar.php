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
     * ID
     *
     * @since 0.6.0
     * @access protected
     *
     * @var string
     */
    protected $id;

    /**
     * Get handle
     *
     * @since 0.6.0
     * @access protected
     */
    protected function getID(): string
    {
        return $this->id;
    }

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
     * Register/unregister widget area
     *
     * @since 0.6.0
     * @access public
     *
     * @action widgets_init
     */
    abstract public function register();
}
