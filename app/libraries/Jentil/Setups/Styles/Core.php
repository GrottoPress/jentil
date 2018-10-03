<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\AbstractTheme;

final class Core extends AbstractStyle
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = $this->app->theme->stylesheet;
    }

    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        $file_system = $this->app->utilities->fileSystem;

        $file = \is_rtl() ?
            '/dist/styles/core-rtl.min.css' :
            '/dist/styles/core.min.css';

        \wp_enqueue_style(
            $this->id,
            $file_system->dir('url', $file),
            [$this->app->setups['Styles\Normalize']->id],
            \filemtime($file_system->dir('path', $file))
        );
    }
}
