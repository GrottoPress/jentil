<?php

/**
 * Layout
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
        if (\is_page_template(['page-builder.php', 'page-builder-blank.php'])) {
            return $classes;
        }
        
        $layout = $this->app->utilities->page->layout;

        if (($mod = $layout->mod()->get())) {
            $classes[] = \sanitize_title('layout-'.$mod);
        }

        if (($column = $layout->column())) {
            $classes[] = \sanitize_title('layout-'.$column);
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
