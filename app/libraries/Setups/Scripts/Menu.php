<?php

/**
 * Menu script
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
 * Menu script
 *
 * @since 0.6.0
 */
final class Menu extends AbstractScript
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

        $this->id = 'jentil-menu';
    }

    /**
     * Enqueue
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                '/dist/scripts/menu.min.js'
            ),
            ['jquery'],
            '',
            true
        );
    }
}
