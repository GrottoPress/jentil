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
        \wp_enqueue_script(
            $this->id,
            'https://use.fontawesome.com/releases/v5.0.11/js/v4-shims.js',
            [$this->app->setups['Scripts\FontAwesome']->id],
            '',
            true
        );
    }
}
