<?php

/**
 * Abstract Stylesheet
 *
 * @package GrottoPress\Jentil\Setups\Styles
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\Setups\AbstractSetup;
use GrottoPress\Getter\Getter;

/**
 * Abstract Stylesheet
 *
 * @since 0.6.0
 */
abstract class AbstractStyle extends AbstractSetup
{
    /**
     * Handle
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
    protected function getID()
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
     * Enqueue/dequeue stylesheet
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    abstract public function enqueue();
}
