<?php

/**
 * Archives
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
 * Archives
 *
 * @since 0.1.0
 */
final class Archives extends Setup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('jentil_before_content', [$this, 'description']);
    }

    /**
     * Description
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_content
     */
    public function description()
    {
        if (!$this->jentil->utilities()->page()->is('archive')) {
            return;
        }

        if (!($description =
            $this->jentil->utilities()->page()->description())
        ) {
            return;
        }

        echo '<div class="archive-description entry-summary" itemprop="description">'.
            $description.
        '</div>';
    }
}
