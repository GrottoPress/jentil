<?php

/**
 * Title Tag
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
 * Title Tag
 *
 * @since 0.1.0
 */
final class Title extends Setup
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
     * Title tag.
     *
     * Add support for the title tag.
     *
     * @since 0.1.0
     * @since WordPress 4.1
     *
     * @access public
     *
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('title-tag');
    }
}
