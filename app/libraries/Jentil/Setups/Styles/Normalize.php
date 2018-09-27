<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use GrottoPress\Jentil\AbstractTheme;

final class Normalize extends AbstractStyle
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'normalize';
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
        $file = '/dist/vendor/normalize.min.css';

        \wp_enqueue_style(
            $this->id,
            $this->app->utilities->fileSystem->dir('url', $file),
            [],
            \filemtime($this->app->utilities->fileSystem->dir('path', $file))
        );
    }
}
