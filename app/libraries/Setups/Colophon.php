<?php

/**
 * Colophon
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Colophon
 *
 * @since 0.1.0
 */
final class Colophon extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('jentil_inside_footer', [$this, 'render']);
    }

    /**
     * Render
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_footer
     */
    public function render()
    {
        if (!($mod = $this->app->utilities->colophon->mod()->get())
            && !$this->app->utilities->page->is('customize_preview')
        ) {
            return;
        }

        echo '<div id="colophon"><small>'.$mod.'</small></div><!-- #colophon -->';
    }
}
