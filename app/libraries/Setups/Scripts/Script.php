<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\AbstractTheme;

final class Script extends AbstractScript
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil';
    }

    public function run()
    {
        parent::run();

        \add_filter('body_class', [$this, 'addBodyClasses']);
    }

    /**
     * @action wp_footer
     */
    public function enqueue()
    {
        \wp_enqueue_script(
            $this->id,
            $this->app->utilities->fileSystem->dir(
                'url',
                '/dist/scripts/jentil.min.js'
            ),
            ['jquery'],
            '',
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
     */
    public function addBodyClasses(array $classes): array
    {
        $classes[] = 'no-js';

        return $classes;
    }
}
