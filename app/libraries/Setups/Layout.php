<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

/**
 * Layout
 *
 * @since 0.1.0
 */
final class Layout extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
        \add_action('after_setup_theme', [$this, 'setContentWidth']);
    }

    /**
     * Add Body Classes
     *
     * @since 0.1.0
     * @access public
     *
     * @filter body_class
     */
    public function addBodyClasses(array $classes): array
    {
        $utilities = $this->app->utilities;

        if ($utilities->customTemplate->isPageBuilder()) {
            return $classes;
        }

        $layout = $utilities->page->layout;

        if (($mod = $layout->themeMod()->get())) {
            $classes[] = \sanitize_title("layout-{$mod}");
        }

        if (($column = $layout->column())) {
            $classes[] = \sanitize_title("layout-{$column}");
        }

        return $classes;
    }

    /**
     * Content width
     *
     * @since 0.1.0
     * @access public
     *
     * @global int $content_width Required by WordPress.
     *
     * @action after_setup_theme
     */
    public function setContentWidth()
    {
        $GLOBALS['content_width'] = 960;
    }
}
