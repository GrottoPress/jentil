<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class Core extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = $this->app->get()->stylesheet;
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
        $file = '/dist/scripts/core.min.js';

        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir('url', $file),
            ['jquery'],
            \filemtime($this->app->utilities->fileSystem->dir('path', $file)),
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
