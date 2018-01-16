<?php

/**
 * Feeds (Atom, RSS etc.)
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Feeds (Atom, RSS etc.)
 *
 * @since 0.1.0
 */
final class Feeds extends AbstractSetup
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
