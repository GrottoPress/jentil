<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class Core extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = $this->app->meta['slug'];
    }

    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        \add_filter('body_class', [$this, 'addBodyClasses']);
    }

    /**
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        $file_system = $this->app->utilities->fileSystem;
        $file = '/dist/scripts/core.min.js';

        \wp_enqueue_script(
            $this->id,
            $file_system->dir('url', $file),
            ['jquery'],
            \filemtime($file_system->dir('path', $file)),
            true
        );
    }

    /**
     * Add 'no-js' class to body
     *
     * This should be removed by our script if
     * javascript is supported by client.
     *
     * @filter body_class
     *
     * @param string[int] $classes
     *
     * @return string[int]
     */
    public function addBodyClasses(array $classes): array
    {
        $classes[] = 'no-js';

        return $classes;
    }
}
