<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Sidebar extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_before_before_footer', [$this, 'load']);
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
}
