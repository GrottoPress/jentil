<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Layout extends AbstractSetup
{
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
        \add_action('after_setup_theme', [$this, 'setContentWidth']);
    }

    /**
     * @filter body_class
     * @param string[int] $classes
     * @return string[int]
     */
    public function addBodyClasses(array $classes): array
    {
        $utilities = $this->app->utilities;

        if ($utilities->postTypeTemplate->isPageBuilder() ||
            $utilities->postTypeTemplate->isPageBuilderBlank()
        ) {
            return $classes;
        }

        $layout = $utilities->page->layout;

        if ($mod = $layout->themeMod()->get()) {
            $classes[] = \sanitize_title("layout-{$mod}");
        }

        if ($column = $layout->column()) {
            $classes[] = \sanitize_title("layout-{$column}");
        }

        return $classes;
    }

    /**
     * @global int $content_width Required by WordPress.
     *
     * @action after_setup_theme
     */
    public function setContentWidth()
    {
        $GLOBALS['content_width'] = 960;
    }
}
