<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Language extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'loadTextDomain' ]);
    }

    /**
     * @action after_setup_theme
     */
    public function loadTextDomain()
    {
        \load_theme_textdomain(
            'jentil',
            $this->app->utilities->fileSystem->dir('path', '/lang')
        );
    }
}
