<?php

/**
 * Archives
 *
 * @package GrottoPress\Jentil\Setups\Views
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Archives
 *
 * @since 0.1.0
 */
final class Archive extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('jentil_before_content', [$this, 'renderDescription']);
    }

    /**
     * Render description
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_content
     */
    public function renderDescription()
    {
        if (!$this->app->utilities->page->is('archive')) {
            return;
        }

        if (!($description =
            $this->app->utilities->page->description())
        ) {
            return;
        }

        echo '<div class="archive-description entry-summary" itemprop="description">'.
            $description.
        '</div>';
    }
}
