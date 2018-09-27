<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class FontAwesomeShim extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->setups['Scripts\FontAwesome']->id}-shim";
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
        $file = '/dist/vendor/font-awesome-v4-shims.min.js';

        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir('url', $file),
            [$this->app->setups['Scripts\FontAwesome']->id],
            \filemtime($this->app->utilities->fileSystem->dir('path', $file)),
            true
        );
    }
}
