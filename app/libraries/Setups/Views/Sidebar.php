<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Sidebar extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_before_before_footer', [$this, 'load']);
        \add_action('jentil_after_after_header', [$this, 'openContentWrapTag']);
        \add_action(
            'jentil_before_before_footer',
            [$this, 'closeContentWrapTag']
        );
    }

    /**
     * @action jentil_before_before_footer
     */
    public function load()
    {
        if ($this->app->utilities->postTypeTemplate->isPageBuilder()) {
            return;
        }

        $this->app->utilities->loader->loadPartial('sidebar');
    }

    /**
     * @action jentil_after_after_header
     */
    public function openContentWrapTag()
    {
        if ($this->app->utilities->postTypeTemplate->isPageBuilder() ||
            'columns-1' === $this->app->utilities->page->layout->column()
        ) {
            return;
        }

        echo '<div id="content-wrap">';
    }

    /**
     * @action jentil_before_before_footer
     */
    public function closeContentWrapTag()
    {
        if ($this->app->utilities->postTypeTemplate->isPageBuilder() ||
            'columns-1' === $this->app->utilities->page->layout->column()
        ) {
            return;
        }

        echo '</div><!-- #content-wrap -->';
    }
}
