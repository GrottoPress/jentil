<?php

/**
 * Updater
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
 * Updater
 *
 * @since 0.1.0
 */
final class Updater extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'checkForUpdate']);
    }

    /**
     * Check for update
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function checkForUpdate()
    {
        $this->jentil->utilities->updater;
    }
}
