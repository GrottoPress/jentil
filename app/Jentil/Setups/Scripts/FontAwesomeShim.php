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
        $file_system = $this->app->utilities->fileSystem;
        $file = '/dist/vendor/font-awesome-v4-shims.min.js';

        \wp_enqueue_script(
            $this->id,
            $file_system->dir('url', $file),
            [$this->app->setups['Scripts\FontAwesome']->id],
            \filemtime($file_system->dir('path', $file)),
            true
        );
    }
}
