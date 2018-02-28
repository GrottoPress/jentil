<?php

/**
 * Abstract Script
 *
 * @package GrottoPress\Jentil\Setups\Scripts
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\Setups\AbstractSetup;

/**
 * Abstract Script
 *
 * @since 0.6.0
 */
abstract class AbstractScript extends AbstractSetup
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
     * Get ID
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
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * Enqueue/dequeue script
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    abstract public function enqueue();
}
