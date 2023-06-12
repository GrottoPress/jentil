<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class jQueryMigrate extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jquery-migrate';
    }

    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'deregister']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function deregister()
    {
        \wp_deregister_script($this->id);
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        $file_system = $this->app->utilities->fileSystem;
        $file = '/dist/vendor/jquery-migrate.min.js';

        \wp_enqueue_script(
            $this->id,
            $file_system->dir('url', $file),
            [$this->app->setups['Scripts\jQuery']->id],
            \filemtime($file_system->dir('path', $file)),
            true
        );
    }
}
