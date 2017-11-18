<?php

/**
 * Feeds (Atom, RSS etc.)
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
 * Feeds (Atom, RSS etc.)
 *
 * @since 0.1.0
 */
class Feeds extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
    }

    /**
     * Add support for RSS and atom feeds
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('automatic-feed-links');
    }
}
