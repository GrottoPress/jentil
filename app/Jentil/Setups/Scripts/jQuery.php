<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class jQuery extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jquery';
    }

    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'deregister']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        \add_action('wp_enqueue_scripts', [$this, 'addInlineScript']);
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
        $file = '/dist/vendor/jquery.min.js';

        \wp_enqueue_script(
            $this->id,
            $file_system->dir('url', $file),
            [],
            \filemtime($file_system->dir('path', $file)),
            true
        );
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function addInlineScript()
    {
        \wp_add_inline_script($this->id, 'jQuery.noConflict();', 'after');
    }
}
