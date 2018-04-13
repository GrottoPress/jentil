<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Updater extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'checkForUpdate']);
    }

    /**
     * @action after_setup_theme
     */
    public function checkForUpdate()
    {
        if ($this->app->is('package')) {
            return;
        }

        $this->app->utilities->updater;
    }
}
