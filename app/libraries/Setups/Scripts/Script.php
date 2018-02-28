<?php

/**
 * Main script
 *
 * @package GrottoPress\Jentil\Setups\Scripts
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

/**
 * Main script
 *
 * @since 0.6.0
 */
final class Script extends AbstractScript
{
    /**
     * Constructor
     *
     * @param AbstractTheme $jentil
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil';
    }

    /**
     * Run setup
     *
     * @since 0.6.0
     * @access public
     */
    public function run()
    {
        parent::run();

        \add_filter('body_class', [$this, 'addBodyClasses']);
    }

    /**
     * Enqueue
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_footer
     */
    public function enqueue()
    {
        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                '/dist/scripts/jentil.min.js'
            ),
            ['jquery'],
            '',
            true
        );
    }

    /**
     * Add 'no-js' class to body
     *
     * This should be removed by our script if
     * javascript is supported by client.
     *
     * @since 0.6.0
     * @access public
     *
     * @filter body_class
     */
    public function addBodyClasses(array $classes): array
    {
        $classes[] = 'no-js';

        return $classes;
    }
}
