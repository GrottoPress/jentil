<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class FontAwesome extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'font-awesome';
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
        $file = '/dist/vendor/font-awesome.min.js';

        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir('url', $file),
            [],
            \filemtime($this->app->utilities->fileSystem->dir('path', $file)),
            true
        );
    }
}
