<?php

/**
 * Colophon
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
        if (!($mod = $this->theme->utilities->colophon->mod())
            && !$this->theme->utilities->page->is('customize_preview')
        ) {
            return;
        }

        echo '<div id="colophon"><small>'.$mod.'</small></div><!-- #colophon -->';
    }
}
