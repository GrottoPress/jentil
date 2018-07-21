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
     * @action jentil_after_after_content
     */
    public function load()
    {
        $this->app->utilities->loader->loadPartial('sidebar');
    }
}
